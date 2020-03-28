<?php


namespace App\Messenger;


use App\MyLogger;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class VkMessenger
{

    public function sendMessageToUser($user, $message)
    {
        return $this->sendMessage($user, $message);
    }

    public function sendMessageToUserWithKeyboard($user, $message, $triggerWords)
    {
        return $this->sendMessage($user, $message, $this->generateKeyboardJson($triggerWords));
    }

    private function sendMessage($user, $message, $keyboardJson = null)
    {
        $randomId = $user->random_id;
        $gluszzClient = new Client([
            'base_uri' => 'https://api.vk.com/method/',
        ]);
        $query = [
            'query' => [
                'access_token' => env('VK_GROUP_TOKEN'),
                'v' => '5.103',
                'random_id' => $randomId,
                'user_id' => $user->vk_user_id,
                'message' => $message,
            ]
        ];
        if ($keyboardJson != null) {
            $query['query']['keyboard'] = $keyboardJson;
        }
        MyLogger::LOG('sendMessageToUser pre get $user' . MyLogger::JSON_ENCODE($user) . ' $query ' . MyLogger::JSON_ENCODE($query));
        $get = $gluszzClient->get('messages.send', $query);
        MyLogger::LOG('sendMessageToUser after get $user' . MyLogger::JSON_ENCODE($user) . ' $get->getBody() ' . MyLogger::JSON_ENCODE($get->getBody()->getContents()));
        if ($get->getStatusCode() == 200) {
            $user->update(['random_id' => $user->random_id + 1]);
            return true;
        } else {
            return false;
        }
    }


    private function generateKeyboardJson(Collection $triggerWords)
    {
//        dd($triggerWords);
        $possibleStates = $triggerWords->filter(function ($value, $key) {
            return $value['state']!='main_screen';
        });
        $buttons = [];
        foreach ($possibleStates as $currState) {
            switch ($currState['type']) {
                case 'text':
                    $buttons[] = [[
                        'action' => [
                            'type' => $currState['type'],
                            'label' => $currState['word']
                        ],
                        'color' => 'secondary'
                    ]];
                    break;
                case 'location':
                    $buttons[] = [[
                        'action' => [
                            'type' => $currState['type']
                        ]
                    ]];
                    break;
            }

        }
        $buttons[] = [[
            'action' => [
                'type' => 'text',
                'label' => __('trigger_words.start_1')
            ],
            'color' => 'secondary'
        ]];
        $buttonsObject = [
            'one_time' => false,
            'buttons' => $buttons,
            'inline' => false
        ];
        $preparedBtnsJson = MyLogger::JSON_ENCODE($buttonsObject);
        MyLogger::LOG('generateKeyboardJson $preparedBtnsJson' . $preparedBtnsJson);
        return $preparedBtnsJson;
    }
}
