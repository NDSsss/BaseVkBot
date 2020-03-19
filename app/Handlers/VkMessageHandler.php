<?php


namespace App\Handlers;


use App\State;
use App\TriggerWord;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VkMessageHandler
{
    function handleMessageRequest(Request $request)
    {
        Log::debug('handleMessageRequest' . json_encode($request));
        $object = $request->input('object');
        $vkUserId = $object['message']['from_id'];
        $foundUser = User::where('vk_user_id', $vkUserId)->get()->first();
        $message = $object['message'];
        if ($foundUser == null) {
            $newUser = new User();
            $newUser->vk_user_id = $vkUserId;
            if ($newUser->save()) {
                $foundUser = User::where('vk_user_id', $vkUserId)->get()->first();
            }
        }

        Log::debug('$foundUser ' . json_encode($foundUser));
        switch ($foundUser->state_id) {
            case 3:
                if (key_exists('geo', $message)) {
                    $this->handleGeoMessage($foundUser, $message['geo']);
                    break;
                }
            default:
                $this->handleUserMessage($foundUser, $message);
                break;
        }
    }

    function handleUserMessage($user, $receivedMessage)
    {
        $receivedMessage = $receivedMessage['text'];
        Log::debug('handleUserMessage $user' . json_encode($user) . ' $receivedMessage ' . json_encode($receivedMessage));
        $userState = $user->state;
        $triggerWords = $this->generateTriggerWordsForState($userState->id);
        $nexStateId = $triggerWords->where('word', $receivedMessage);
        if ($nexStateId->isNotEmpty()) {
            $this->moveUserToState($user, $nexStateId->first()->state_id);
        } else {

        }
    }

    function handleGeoMessage($user, $geo)
    {
        Log::debug('handleGeoMessage $user' . json_encode($user) . ' $geo ' . json_encode($geo));
        $coordinates = $geo['coordinates'][''].','.$geo['coordinates'][''];
        $user->coordinates = $coordinates;
        $user->save();
        $userState = $user->state;
    }

    private function moveUserToState($user, $newStateId)
    {
        Log::debug('moveUserToState $user' . json_encode($user) . ' $newStateId ' . json_encode($newStateId));
        $user->state_id = $newStateId;
        $newState = State::query()->where('id', '=', $newStateId)->get()->first();
        if ($this->sendMessageToUser($user, $newState->message, $user->random_id, $newStateId)) {
            $user->save();
        };
    }

    private function sendMessageToUser($user, $message, $randomId, $newStateId)
    {
        $gluszzClient = new Client([
            'base_uri' => 'https://api.vk.com/method/',
        ]);
        $keyboardjson = $this->generateKeyboardJson($newStateId);
        $query = [
            'query' => [
                'access_token' => env('VK_GROUP_TOKEN'),
                'v' => '5.103',
                'random_id' => $randomId,
                'user_id' => $user->vk_user_id,
                'message' => $message,
                'keyboard' => $keyboardjson,
            ]
        ];
        Log::debug('sendMessageToUser pre get $user' . json_encode($user) . ' $query ' . json_encode($query));
        $get = $gluszzClient->get('messages.send', $query);
        Log::debug('sendMessageToUser after get $user' . json_encode($user) . ' $get->getStatusCode() ' . json_encode($get->getStatusCode()));
        if ($get->getStatusCode() == 200) {
            $user->update(['random_id' => $user->random_id + 1]);
            return true;
        } else {
            return false;
        }
    }

    private function generateKeyboardJson($newStateId)
    {
        $possibleStates = $this->generateTriggerWordsForState($newStateId);
        $buttons = [];
        foreach ($possibleStates as $currState) {
            switch($currState->type){
                case 'text':
                    $buttons[] = [[
                        'action' => [
                            'type' => $currState->type,
                            'label' => $currState->word
                        ],
                        'color' => 'secondary'
                    ]];
                    break;
                case 'location':
                    $buttons[] = [[
                        'action' => [
                            'type' => $currState->type
                        ]
                    ]];
                    break;
            }

        }
        $buttonsObject = [
            'one_time' => false,
            'buttons' => $buttons,
            'inline' => false
        ];
        $preparedBtnsJson = json_encode($buttonsObject);
        Log::debug('generateKeyboardJson $preparedBtnsJson' . json_encode($preparedBtnsJson));
        echo json_encode($buttonsObject);
        return json_encode($buttonsObject);
    }

    private function generateTriggerWordsForState($stateId)
    {
        $userPossibleStates = DB::table('possible_states')
            ->where('current_state_id', '=', $stateId)
            ->get('possible_state_id')
            ->map(function ($item, $key) {
                return $item->possible_state_id;
            })
            ->toArray();
        $triggerWords = TriggerWord::query()
            ->whereIn('state_id', $userPossibleStates)
            ->get()
            ->filter(function ($value, $key) {
                return $value->id != 1;
            });

        return $triggerWords;
    }

}
