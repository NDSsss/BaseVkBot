<?php


namespace App\Handlers;


use Illuminate\Support\Facades\Lang;

class StatesHandler
{

    function isStartTriggerWord($word){
        switch ($word){
            case __('trigger_words.start_1'):
            case __('trigger_words.start_2'):
            case __('trigger_words.start_3'):
            case __('trigger_words.start_4'):
            case __('trigger_words.start_5'):
            case __('trigger_words.start_6'):
            case __('trigger_words.start_7'):
            case __('trigger_words.start_8'):
            case __('trigger_words.start_9'):
                return true;
            default :
                return false;
        }
    }

}
