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
        $values[] = ['current_state'=>StatesNamesEnum::$MAIN_SCREEN,'possible_state'=>StatesNamesEnum::$SUBSCRIBE_INIT,];
        $values[] = ['current_state'=>StatesNamesEnum::$MAIN_SCREEN,'possible_state'=>StatesNamesEnum::$VOLUNTEERS,];

//        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT,'possible_state'=>StatesNamesEnum::$MAIN_SCREEN,];
//        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT,'possible_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_ACCEPT,];

        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_ALREADY_SUB,'possible_state'=>StatesNamesEnum::$MAIN_SCREEN,];
        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_ALREADY_SUB,'possible_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_REQUEST,];

        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_NOT_SUBBED,'possible_state'=>StatesNamesEnum::$MAIN_SCREEN,];
        $values[] = ['current_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_NOT_SUBBED,'possible_state'=>StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_REQUEST,];

        $valuesCollection = collect($values);
        return $valuesCollection;
    }
}
