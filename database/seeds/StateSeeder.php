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

        $values[] = ['name'=>'Начало','message'=>'welcome'];

        \Illuminate\Support\Facades\DB::table('states')->insert($values);
    }
}
