<?php


namespace App\Managers;


use Illuminate\Support\Collection;

class PossibleStatesManager
{
    function getPossibleStates():Collection{

        $values = [];

        $values[] = ['current_state'=>'start','possible_state'=>'main_screen',];
        $values[] = ['current_state'=>'main_screen','possible_state'=>'reminder',];
        $values[] = ['current_state'=>'main_screen','possible_state'=>'subscribe_init',];
        $values[] = ['current_state'=>'subscribe_init','possible_state'=>'main_screen',];
        $values[] = ['current_state'=>'subscribe_init','possible_state'=>'subscribe_accept',];
        $values[] = ['current_state'=>'main_screen','possible_state'=>'volunteers',];

        $valuesCollection = collect($values);
        return $valuesCollection;
    }
}
