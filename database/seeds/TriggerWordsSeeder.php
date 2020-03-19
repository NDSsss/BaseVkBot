<?php

use Illuminate\Database\Seeder;

class TriggerWordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [];

        $values[] = ['id'=>1,'state_id'=>2,'type'=>'text','word'=>'Понятно'];
        $values[] = ['id'=>2,'state_id'=>2,'type'=>'text','word'=>'Начало'];
        $values[] = ['id'=>3,'state_id'=>3,'type'=>'text','word'=>'Чат моего дома'];
        $values[] = ['id'=>4,'state_id'=>4,'type'=>'text','word'=>'Нужна помощь'];
        $values[] = ['id'=>5,'state_id'=>5,'type'=>'location','word'=>'geo'];

        \Illuminate\Support\Facades\DB::table('trigger_words')->insert($values);
    }
}
