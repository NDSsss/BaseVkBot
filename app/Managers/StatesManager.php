<?php


namespace App\Managers;


use App\Enums\StateTypesEnum;
use Illuminate\Support\Collection;

class StatesManager
{
    public function getStates(): Collection
    {

        $values = [];

        $values[] = [
            'name' => 'Начало',
            'state' => 'start',
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages'=>['start'],
            ];
        $values[] = [
            'name' => 'Главный экран',
            'state' => 'main_screen',
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages'=>['main_screen'],
            ];
        $values[] = [
            'name' => 'Памятка',
            'state' => 'reminder',
            'state_type' => StateTypesEnum::$JUST_SEND_MESSAGE,
            'state_messages'=>['reminder'],
            ];
        $values[] = [
            'name' => 'Подписка только нажал на кнопку',
            'state' => 'subscribe_init',
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages'=>['subscribe_init'],
            ];
        $values[] = [
            'name' => 'Подтвердил подписку',
            'state' => 'subscribe_accept',
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_GO_TO_MAIN,
            'state_messages'=>['subscribe_accept_success_new'],
            ];
        $values[] = [
            'name' => 'Волонтерам',
            'state' => 'volunteers',
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_GO_TO_MAIN,
            'state_messages'=>['volunteers_1','volunteers_2'],
            ];


        $valuesCollection = collect($values);
        return $valuesCollection;
    }
}
