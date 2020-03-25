<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VkController extends Controller
{
    public function vkEvent(Request $request){
        \Illuminate\Support\Facades\Log::debug('vk bot'.json_encode($request->input()));
        if($request->input('group_id') == env('VK_GROUP_ID')){
            switch ($request->input('type')){
                case 'confirmation':
                    return env('VK_GROUP_SECRET');
                    break;
                case 'message_new':
                    $vkMassagesHandler = app(\App\Handlers\VkMessageHandler::class);
                    $vkMassagesHandler->handleMessageRequest($request);
                    return 'ok';
                    break;
                default:
                    return 'ok';
            }
        } else {
            return \Illuminate\Http\Response::create(null,404);
        }
    }
}
