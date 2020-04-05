<?php


namespace App\Managers;


use App\Enums\StatesNamesEnum;
use Illuminate\Support\Collection;

class PossibleStatesManager
{
    function getPossibleStates():Collection{

        $values = [];

        $values[] = ['current_state'=>StatesNamesEnum::$START,'possible_state'=>StatesNamesEnum::$MAIN_SCREEN,];

        $values[] = ['current_state'=>StatesNamesEnum::$MAIN_SCREEN,'possible_state'=>StatesNamesEnum::$REMINDER,];
        $values[] = ['current_state'=>StatesNamesEnum::$MAIN_SCREEN,'possible_state'=>StatesNamesEnum::$HELP,];
        $values[] = ['current_state'=>StatesNamesEnum::$MAIN_SCREEN,'possible_state'=>StatesNamesEnum::$SUBSCRIBE_INIT,];
        $values[] = ['current_state'=>StatesNamesEnum::$MAIN_SCREEN,'possible_state'=>StatesNamesEnum::$VOLUNTEERS,];

//        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT,'possible_state'=>StatesNamesEnum::$MAIN_SCREEN,];
//        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT,'possible_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_ACCEPT,];

        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_ALREADY_SUB,'possible_state'=>StatesNamesEnum::$MAIN_SCREEN,];
        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_ALREADY_SUB,'possible_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_REQUEST,];

        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_NOT_SUBBED,'possible_state'=>StatesNamesEnum::$MAIN_SCREEN,];
        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_NOT_SUBBED,'possible_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_REQUEST,];

        $values[] = ['current_state'=>StatesNamesEnum::$HELP,'possible_state'=>StatesNamesEnum::$HELP_GET_NEAR_CHAT_REQUEST,];
        $values[] = ['current_state'=>StatesNamesEnum::$HELP,'possible_state'=>StatesNamesEnum::$HELP_USER_ADDRESS_INPUT,];

        $values[] = ['current_state'=>StatesNamesEnum::$HELP_CHAT_FOUND,'possible_state'=>StatesNamesEnum::$HELP_CHAT_WAIT_LINK,];
        $values[] = ['current_state'=>StatesNamesEnum::$HELP_CHAT_FOUND,'possible_state'=>StatesNamesEnum::$HELP_USER_ADDRESS_INPUT,];

        $values[] = ['current_state'=>StatesNamesEnum::$HELP_CHAT_NOT_FOUND,'possible_state'=>StatesNamesEnum::$HELP_CHAT_WAIT_LINK,];
        $values[] = ['current_state'=>StatesNamesEnum::$HELP_CHAT_NOT_FOUND,'possible_state'=>StatesNamesEnum::$HELP_USER_ADDRESS_INPUT,];

        $values[] = ['current_state'=>StatesNamesEnum::$HELP_USER_ADDRESS_INPUT,'possible_state'=>StatesNamesEnum::$HELP_GET_NEAR_CHAT_REQUEST,];

        $values[] = ['current_state'=>StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_SUCCESS,'possible_state'=>StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_USER_ACCEPT,];
        $values[] = ['current_state'=>StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_SUCCESS,'possible_state'=>StatesNamesEnum::$HELP_USER_ADDRESS_INPUT,];

        $valuesCollection = collect($values);
        return $valuesCollection;
    }
}
