<?php

use Illuminate\Database\Seeder;

class PossibleStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [];

        $values[] = ['current_state_id'=>1,'possible_state_id'=>2,];
        $values[] = ['current_state_id'=>2,'possible_state_id'=>8,];
        $values[] = ['current_state_id'=>2,'possible_state_id'=>4,];
        $values[] = ['current_state_id'=>3,'possible_state_id'=>2,];
        $values[] = ['current_state_id'=>3,'possible_state_id'=>5,];
        $values[] = ['current_state_id'=>5,'possible_state_id'=>2,];
        $values[] = ['current_state_id'=>6,'possible_state_id'=>2,];
        $values[] = ['current_state_id'=>6,'possible_state_id'=>7,];
        $values[] = ['current_state_id'=>7,'possible_state_id'=>2,];
        $values[] = ['current_state_id'=>4,'possible_state_id'=>2,];
        $values[] = ['current_state_id'=>8,'possible_state_id'=>3,];
        $values[] = ['current_state_id'=>8,'possible_state_id'=>2,];
        $values[] = ['current_state_id'=>8,'possible_state_id'=>9,];
        $values[] = ['current_state_id'=>9,'possible_state_id'=>2,];

        \Illuminate\Support\Facades\DB::table('possible_states')->insert($values);
    }
}
