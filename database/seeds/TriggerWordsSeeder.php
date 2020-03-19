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

        $values[] = ['id'=>1,'state_id'=>2,'word'=>'Понятно'];
        $values[] = ['id'=>2,'state_id'=>2,'word'=>'Начало'];
        $values[] = ['id'=>3,'state_id'=>3,'word'=>'Чат моего дома'];
        $values[] = ['id'=>4,'state_id'=>4,'word'=>'Нужна помощь'];

        \Illuminate\Support\Facades\DB::table('trigger_words')->insert($values);
    }
}
