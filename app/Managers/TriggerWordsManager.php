<?php


namespace App\Managers;


use App\Enums\TriggerTypeEnum;
use Illuminate\Support\Collection;

class TriggerWordsManager
{
    public function getTriggerWords(): Collection
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
        $values[] = ['state' => 'main_screen', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.start_1'),];
        $values[] = ['state' => 'reminder', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.reminder'),];
        $values[] = ['state' => 'volunteers', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.volunteers'),];
        $values[] = ['state' => 'subscribe_init', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.subscribe_init'),];
        $values[] = ['state' => 'subscribe_accept', 'type' => TriggerTypeEnum::$TEXT, 'word' => __('trigger_words.subscribe_accept'),];

        $valuesCollection = collect($values);
        return $valuesCollection;
    }
}
