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

        $values[] = ['id' => 1, 'name' => 'Начало', 'message' => 'start'];
        $values[] = ['id' => 2, 'name' => 'Главный экран', 'message' => 'main_screen'];
        $values[] = ['id' => 3, 'name' => 'Начало флоу чат моего дома', 'message' => 'my_house'];
        $values[] = ['id' => 4, 'name' => 'Памятка', 'message' => 'reminder'];
        $values[] = ['id' => 5, 'name' => 'чат моего дома  получили локацию', 'message' => 'chat_exists'];
        $values[] = ['id' => 6, 'name' => 'чат моего дома  получили локацию', 'message' => 'chat_not_exists'];
        $values[] = ['id' => 7, 'name' => 'чат моего дома  Создание чата', 'message' => 'creating_chat'];
        $values[] = ['id' => 8, 'name' => 'Нажал кнопку хочу помочь предлагать 2 действия и начало', 'message' => 'join_project'];
        $values[] = ['id' => 9, 'name' => 'Нажал кнопку хочу помочь и потом инструкции', 'message' => 'instructions'];

        \Illuminate\Support\Facades\DB::table('states')->insert($values);
    }
}
