<?php


namespace App\Handlers;


use Illuminate\Http\Request;

class VkMessageHandler
{
    function handleMessage(Request $request){
        $object = $request->input('object');
        $userId = $object['user_id'];
        dd($userId);
    }

}
