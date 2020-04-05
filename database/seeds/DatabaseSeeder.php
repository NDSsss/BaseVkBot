<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UsersTableSaver::CREATE_OLD_USERS_TABLE();
//        $this->call(StateSeeder::class);
    }
}
