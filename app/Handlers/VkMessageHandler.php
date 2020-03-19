<?php


namespace App\Handlers;


use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class VkMessageHandler
{
    function handleMessage(Request $request)
    {
        $object = $request->input('object');
        $vkUserId = $object['message']['from_id'];
        $foundUser = User::where('vk_user_id', $vkUserId)->get()->first();
        if ($foundUser == null) {
            $newUser = new User();
            $newUser->vk_user_id = $vkUserId;
            if ($newUser->save()) {
                $foundUser = User::where('vk_user_id', $vkUserId)->get()->first();
            }
        }

        switch ($foundUser->state_id) {
            case 1:
                $this->sendStateMessage($foundUser);
                break;
        }
        $foundUser->update(['random_id'=>$foundUser->random_id + 1]);
    }

    function sendStateMessage($user)
    {
        $this->sendMessageToUser($user->vk_user_id, $user->state->message, $user->random_id);
    }

    private function sendMessageToUser($vkUserId, $message, $randomId)
    {
        $gluszzClient = new Client([
            'base_uri' => 'https://api.vk.com/method/',
        ]);
        $buttonsObject = [
            'one_time' => false,
            'buttons' => [
                [
                    [
                        'action' => [
                            'type' => 'text',
                            'label' => 'label'
                        ],
                        'color' => 'secondary'
                    ],
                ],
            ],
            'inline' => false
        ];
        $keyboardjson = json_encode($buttonsObject);
//        dd($buttonsObject, json_encode($buttonsObject));
        $get = $gluszzClient->get('messages.send', [
            'query' => [
                'access_token' => env('VK_GROUP_TOKEN'),
                'v' => '5.103',
                'random_id' => $randomId,
                'user_id' => $vkUserId,
                'message' => $message,
                'keyboard' => $keyboardjson,
            ]
        ]);
    }

}
