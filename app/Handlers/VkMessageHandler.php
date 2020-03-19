<?php


namespace App\Handlers;


use App\State;
use App\TriggerWord;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VkMessageHandler
{
    function handleMessageRequest(Request $request)
    {
        $object = $request->input('object');
        $vkUserId = $object['message']['from_id'];
        $foundUser = User::where('vk_user_id', $vkUserId)->get()->first();
        $messageText = $object['message']['text'];
        if ($foundUser == null) {
            $newUser = new User();
            $newUser->vk_user_id = $vkUserId;
            if ($newUser->save()) {
                $foundUser = User::where('vk_user_id', $vkUserId)->get()->first();
            }
        }

        switch ($foundUser->state_id) {
            default:
                $this->handleUserMessage($foundUser, $messageText);
                break;
        }
    }

    function handleUserMessage($user, $receivedMessage)
    {
        $userState = $user->state;
        $triggerWords = $this->generateTriggerWordsForState($userState->id);
        $nexStateId = $triggerWords->where('word', $receivedMessage);
        if ($nexStateId->isNotEmpty()) {
            $this->moveUserToState($user, $nexStateId->first()->state_id);
        } else {

        }
    }

    private function moveUserToState($user, $newStateId)
    {
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
        $get = $gluszzClient->get('messages.send', [
            'query' => [
                'access_token' => env('VK_GROUP_TOKEN'),
                'v' => '5.103',
                'random_id' => $randomId,
                'user_id' => $user->vk_user_id,
                'message' => $message,
                'keyboard' => $keyboardjson,
            ]
        ]);
        if ($get->getStatusCode() == 200) {
            $user->update(['random_id' => $user->random_id + 1]);
            return true;
        } else {
            return false;
        }
    }

    private function generateKeyboardJson($newStateId)
    {
        $possibleStates = $this->generateTriggerWordsForState($newStateId)
            ->map(function ($value, $key) {
                return $value->word;
            });
        $buttons = [];
        foreach ($possibleStates as $currState) {
            $buttons[] = [
                'action' => [
                    'type' => 'text',
                    'label' => $currState
                ],
                'color' => 'secondary'
            ];

        }
        $buttonsObject = [
            'one_time' => false,
            'buttons' => [$buttons],
            'inline' => false
        ];
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
