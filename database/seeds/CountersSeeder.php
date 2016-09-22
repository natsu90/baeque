<?php

use Carbon\Carbon;
use App\Counter;
use Illuminate\Database\Seeder;

class CountersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($a = 1; $a < 5; $a++) {
            $counter = new counter;
            $counter->premise_id = 1;

            $list = [];

           	$test = rand(2, 5);
           	for ($b = 1; $b < $test; $b++) {
           		array_push($list, $b);
           	}

            $counter->activity_enabled = json_encode($list);
            $counter->name = "Kaunter " . $a;
            $counter->online = true;
            $counter->last_online = Carbon::now();
            $counter->save();
	    }
    }
}
