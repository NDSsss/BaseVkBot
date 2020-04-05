<?php

namespace App\Http\Controllers;

use App\Handlers\SomeApiInteractor;
use App\Messenger\VkMessenger;
use App\MyLogger;
use CreateUsersTable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use UsersTableSaver;

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

    public function migrate()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->integer('vk_user_id')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('city')->nullable();
            $table->string('coordinates')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('state')->default('main_screen');
            $table->unsignedBigInteger('random_id')->default(1);
        });
        $oldUsers = \DB::table('users_old')->get();
        $newUsersFromOld = $oldUsers->map(function ($item) {
            $newItem = [];
            $newItem['id'] = $item->id;
            $newItem['vk_user_id'] = $item->vk_user_id;
            $newItem['random_id'] = $item->random_id;
            return $newItem;
        });
        $newUsersFromOldArray = $newUsersFromOld->toArray();
        \DB::table('users')->insert($newUsersFromOldArray);
    }

}
