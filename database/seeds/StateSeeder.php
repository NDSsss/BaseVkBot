<?php

use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [];

        $values[] = ['id'=>1,'name'=>'Начало','message'=>'welcome message'];
        $values[] = ['id'=>2,'name'=>'Главный экран','message'=>'main screen instructions'];
        $values[] = ['id'=>3,'name'=>'Начало флоу чат моего дома','message'=>'house chat step 1. Request location'];
        $values[] = ['id'=>4,'name'=>'Начало флоу нужна помощь','message'=>'Текстовка нужна помощь. Выберите какая помощь необходима'];
        $values[] = ['id'=>5,'name'=>'чат моего дома  получили локацию','message'=>'Локация получена. Ваш ближайший чат'];

        \Illuminate\Support\Facades\DB::table('states')->insert($values);
    }
}
