<?php

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
    	for ($a = 0; $a < 5; $a++) {
	        $premise = new Premise;
	        $premise->name = "Klinik Kesihatan Beranang";
	        $premise->location = "Beranang, Selangor.";
	        $premise->logo = "/logo/klinik.png";
	        $premise->desc = "Sebuah klinik kecil yang terletak di Beranang.";
	        $premise->owner = 1;
	        $premise->save();
	    }
    }
}
