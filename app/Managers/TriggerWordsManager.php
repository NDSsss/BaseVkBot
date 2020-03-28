<?php


namespace App\Managers;


use App\Enums\StatesNamesEnum;
use App\Enums\TriggerTypeEnum;
use Illuminate\Support\Collection;

class TriggerWordsManager
{
    public function getTriggerWords(): Collection
    {

        $values = [];

        $values[] = ['state' => StatesNamesEnum::$MAIN_SCREEN, 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.start_1'),];
        $values[] = [
            'state' => StatesNamesEnum::$REMINDER,
            'type' => TriggerTypeEnum::$TEXT,
            'word' => __('trigger_words.' . StatesNamesEnum::$REMINDER),
        ];
        $values[] = [
            'state' => StatesNamesEnum::$VOLUNTEERS,
            'type' => TriggerTypeEnum::$TEXT,
            'word' => __('trigger_words.' . StatesNamesEnum::$VOLUNTEERS),
        ];
        $values[] = [
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT,
            'type' => TriggerTypeEnum::$TEXT,
            'word' => __('trigger_words.' . StatesNamesEnum::$SUBSCRIBE_INIT),
        ];
        $values[] = [
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_REQUEST,
            'type' => TriggerTypeEnum::$TEXT,
            'word' => __('trigger_words.' . StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_REQUEST),
        ];
        $values[] = [
            'state' => StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_REQUEST,
            'type' => TriggerTypeEnum::$TEXT,
            'word' => __('trigger_words.' . StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_REQUEST),
        ];
//        $values[] = ['state' => 'subscribe_accept', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.subscribe_accept'),];

        $valuesCollection = collect($values);
        return $valuesCollection;
    }

    public function getMainScreenTriggerWords()
    {

        $values = [];

        $values[] = ['state' => 'main_screen', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.start_1'),];
        $values[] = ['state' => 'main_screen', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.start_2'),];
        $values[] = ['state' => 'main_screen', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.start_3'),];
        $values[] = ['state' => 'main_screen', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.start_4'),];
        $values[] = ['state' => 'main_screen', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.start_5'),];
        $values[] = ['state' => 'main_screen', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.start_6'),];
        $values[] = ['state' => 'main_screen', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.start_7'),];
        $values[] = ['state' => 'main_screen', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.start_8'),];

        $valuesCollection = collect($values);
        return $valuesCollection;
    }
}
