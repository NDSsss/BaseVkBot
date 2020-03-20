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

        $values[] = ['id'=>1,'state_id'=>2,'type'=>'text','word'=>'Начало'];
        $values[] = ['id'=>2,'state_id'=>2,'type'=>'text','word'=>'Начало'];
        $values[] = ['id'=>3,'state_id'=>2,'type'=>'text','word'=>'Начать'];
        $values[] = ['id'=>4,'state_id'=>2,'type'=>'text','word'=>'Start'];
        $values[] = ['id'=>5,'state_id'=>2,'type'=>'text','word'=>'начало'];
        $values[] = ['id'=>6,'state_id'=>2,'type'=>'text','word'=>'начало'];
        $values[] = ['id'=>7,'state_id'=>2,'type'=>'text','word'=>'начать'];
        $values[] = ['id'=>8,'state_id'=>2,'type'=>'text','word'=>'start'];
        $values[] = ['id'=>9,'state_id'=>2,'type'=>'text','word'=>'Начало'];
        $values[] = ['id'=>10,'state_id'=>3,'type'=>'text','word'=>'Чат моего дома'];
        $values[] = ['id'=>11,'state_id'=>4,'type'=>'text','word'=>'Памятка'];
        $values[] = ['id'=>12,'state_id'=>5,'type'=>'location','word'=>'geo'];
        $values[] = ['id'=>13,'state_id'=>7,'type'=>'text','word'=>'Создать чат'];

        \Illuminate\Support\Facades\DB::table('trigger_words')->insert($values);
    }
}
