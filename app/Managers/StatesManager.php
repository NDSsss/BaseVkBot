<?php


namespace App\Managers;


use App\Enums\StatesNamesEnum;
use App\Enums\StateTypesEnum;
use Illuminate\Support\Collection;

class StatesManager
{
    public function getStates(): Collection
    {

        $values = [];

        $values[] = [
            'name' => 'Начало',
            'state' => StatesNamesEnum::$START,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages' => ['start'],
        ];
        $values[] = [
            'name' => 'Главный экран',
            'state' => StatesNamesEnum::$MAIN_SCREEN,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages' => ['main_screen'],
        ];
        $values[] = [
            'name' => 'Ошибка при запросе',
            'state' => StatesNamesEnum::$REQUEST_ERROR,
            'state_type' => StateTypesEnum::$JUST_SEND_MESSAGE,
            'state_messages' => [StatesNamesEnum::$REQUEST_ERROR],
        ];


        $values[] = [
            'name' => 'Памятка',
            'state' => StatesNamesEnum::$REMINDER,
            'state_type' => StateTypesEnum::$JUST_SEND_MESSAGE,
            'state_messages' => ['reminder'],
        ];
        $values[] = [
            'name' => 'Подписка только нажал на кнопку',
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT,
            'state_type' => StateTypesEnum::$MAKE_SOME_ACTIONS,
            'state_messages' => ['subscribe_init'],
        ];
        $values[] = [
            'name' => 'Подписка нажал на кнопку и уже подписан',
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT_ALREADY_SUB,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages' => ['subscribe_init_already_sub'],
        ];
        $values[] = [
            'name' => 'Подписка нажал на кнопку и НЕ подписан',
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT_NOT_SUBBED,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages' => ['subscribe_init_NOT_subbed'],
        ];
        $values[] = [
            'name' => 'Подтвердил подписку',
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT_ACCEPT,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_GO_TO_MAIN,
            'state_messages' => ['subscribe_accept_success_new'],
        ];
        $values[] = [
            'name' => 'Отписывается запрос',
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_REQUEST,
            'state_type' => StateTypesEnum::$MAKE_SOME_ACTIONS,
            'state_messages' => [StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_REQUEST],
        ];
        $values[] = [
            'name' => 'Отписывается запрос выполнен успешно',
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_SUCCESS,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_GO_TO_MAIN,
            'state_messages' => [StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_SUCCESS],
        ];
        $values[] = [
            'name' => 'Подписывается запрос',
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_REQUEST,
            'state_type' => StateTypesEnum::$MAKE_SOME_ACTIONS,
            'state_messages' => [StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_REQUEST],
        ];
        $values[] = [
            'name' => 'Подписывается запрос выполнен успешно',
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_SUCCESS,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_GO_TO_MAIN,
            'state_messages' => [StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_SUCCESS],
        ];
        $values[] = [
            'name' => 'Подтвердил подписку',
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT_ACCEPT,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_GO_TO_MAIN,
            'state_messages' => ['subscribe_accept_success_new'],
        ];
        $values[] = [
            'name' => 'Волонтерам',
            'state' => StatesNamesEnum::$VOLUNTEERS,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_GO_TO_MAIN,
            'state_messages' => [
                StatesNamesEnum::$VOLUNTEERS . '_1',
                StatesNamesEnum::$VOLUNTEERS . '_2'
            ],
        ];


        $valuesCollection = collect($values);
        return $valuesCollection;
    }
}
