<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('vkBot',function (Request $request){
    if($request->input('group_id') == env('VK_GROUP_ID')){
        switch ($request->input('type')){
            case 'confirmation':
                echo env('VK_GROUP_SECRET');
                break;
            case 'message_new':
                echo 'ok';
                $vkMassagesHandler = app(\App\Handlers\VkMessageHandler::class);
                $vkMassagesHandler->handleMessage($request);
                break;
        }
    } else {
        return \Illuminate\Http\Response::create(null,404);
    }
});
