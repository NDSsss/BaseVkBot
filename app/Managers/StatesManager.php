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
        $values[] = [
            'name' => 'Помочь, чат дома',
            'state' => StatesNamesEnum::$HELP,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages' => [
                StatesNamesEnum::$HELP . '_1',
                StatesNamesEnum::$HELP . '_2'
            ],
        ];
        $values[] = [
            'name' => 'Помочь, сохранние пользователя',
            'state' => StatesNamesEnum::$HELP_SAVE_USER_WITH_GEO_REQUEST,
            'state_type' => StateTypesEnum::$MAKE_SOME_ACTIONS,
            'state_messages' => [],
        ];
        $values[] = [
            'name' => 'Помочь, сохранние пользователя',
            'state' => StatesNamesEnum::$HELP_GET_CHAT_REQUEST,
            'state_type' => StateTypesEnum::$MAKE_SOME_ACTIONS,
            'state_messages' => [],
        ];
        $values[] = [
            'name' => 'Помочь, чат найден',
            'state' => StatesNamesEnum::$HELP_CHAT_FOUND,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages' => [
                StatesNamesEnum::$HELP_CHAT_FOUND
            ],
        ];
        $values[] = [
            'name' => 'Помочь, чат не найден',
            'state' => StatesNamesEnum::$HELP_CHAT_NOT_FOUND,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages' => [
                StatesNamesEnum::$HELP_CHAT_NOT_FOUND . '_1',
                StatesNamesEnum::$HELP_CHAT_NOT_FOUND . '_2'
            ],
        ];
        $values[] = [
            'name' => 'Помочь, ждем ссылку на чат',
            'state' => StatesNamesEnum::$HELP_CHAT_WAIT_LINK,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages' => [
                StatesNamesEnum::$HELP_CHAT_WAIT_LINK
            ],
        ];
        $values[] = [
            'name' => 'Помочь, ждем ссылку на чат, ссылка не валидна',
            'state' => StatesNamesEnum::$HELP_CHAT_WAIT_LINK_VALIDATION_ERROR,
            'state_type' => StateTypesEnum::$JUST_SEND_MESSAGE,
            'state_messages' => [
                StatesNamesEnum::$HELP_CHAT_WAIT_LINK_VALIDATION_ERROR
            ],
        ];
        $values[] = [
            'name' => 'Помочь, чат найден',
            'state' => StatesNamesEnum::$HELP_CHAT_LINK_NOT_VALID,
            'state_type' => StateTypesEnum::$JUST_SEND_MESSAGE,
            'state_messages' => [
                StatesNamesEnum::$HELP_CHAT_LINK_NOT_VALID
            ],
        ];
        $values[] = [
            'name' => 'Помочь, создание чата',
            'state' => StatesNamesEnum::$HELP_CREATE_CHAT_REQUEST,
            'state_type' => StateTypesEnum::$MAKE_SOME_ACTIONS,
            'state_messages' => [],
        ];
        $values[] = [
            'name' => 'Помочь, чат создан',
            'state' => StatesNamesEnum::$HELP_CREATE_CHAT_SUCCESS,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_GO_TO_MAIN,
            'state_messages' => [
                StatesNamesEnum::$HELP_CREATE_CHAT_SUCCESS
            ],
        ];
        $values[] = [
            'name' => 'Помочь, ввести адрес вручную',
            'state' => StatesNamesEnum::$HELP_USER_ADDRESS_INPUT,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages' => [
                StatesNamesEnum::$HELP_USER_ADDRESS_INPUT
            ],
        ];
        $values[] = [
            'name' => 'Помочь, ввести адрес вручную, распознали успешно',
            'state' => StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_SUCCESS,
            'state_type' => StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE,
            'state_messages' => [
                StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_SUCCESS
            ],
        ];
        $values[] = [
            'name' => 'Помочь, ввести адрес вручную, распознать не получилось',
            'state' => StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_FAIL,
            'state_type' => StateTypesEnum::$JUST_SEND_MESSAGE,
            'state_messages' => [
                StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_FAIL
            ],
        ];
        $values[] = [
            'name' => 'Помочь, ввести адрес вручную, распознать не получилось',
            'state' => StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_USER_ACCEPT,
            'state_type' => StateTypesEnum::$MAKE_SOME_ACTIONS,
            'state_messages' => [
                StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_USER_ACCEPT
            ],
        ];


        $valuesCollection = collect($values);
        return $valuesCollection;
    }
}
