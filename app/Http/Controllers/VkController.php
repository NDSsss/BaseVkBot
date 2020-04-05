<?php

namespace App\Http\Controllers;

use App\Handlers\SomeApiInteractor;
use App\MyLogger;
use Illuminate\Http\Request;

class VkController extends Controller
{
    public function vkEvent(Request $request)
    {
        MyLogger::LOG('VK REQUEST INPUT ' . MyLogger::JSON_ENCODE($request->input()));
        if ($request->input('group_id') == env('VK_GROUP_ID')) {
            switch ($request->input('type')) {
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
            return \Illuminate\Http\Response::create(null, 404);
        }
    }

    public function test(SomeApiInteractor $apiInteractor)
    {
        $apiInteractor->isSubscribedTest();
    }
}
