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
        $vkUserId = $object['user_id'];
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

        dd($foundUser);
    }

    function sendStateMessage($user)
    {
        $this->sendMessageToUser($user->vk_user_id, $user->state->message);
    }

    private function sendMessageToUser($vkUserId, $message)
    {
        $gluszzClient = new Client([
            'base_uri' => 'https://api.vk.com/method/',
        ]);
        $get = $gluszzClient->get('messages.send', [
            'query' => [
                'access_token' => env('VK_GROUP_TOKEN'),
                'v' => '5.69',
                'user_id' => $vkUserId,
                'message' => $message,
            ]
        ]);
        echo 'message send userId ' . $vkUserId . ' $message ' . $message;
    }

}
