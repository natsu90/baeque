<?php

use App\Premise;
use Illuminate\Database\Seeder;

class PremiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $premise = new Premise;
        $premise->name = "Pejabat Pos Semenyih";
        $premise->location = "Semenyih, Selangor.";
        $premise->logo = "/logo/pejabat.png";
        $premise->desc = "Opens 9 AM - 6 PM.";
        $premise->owner = 1;
        $premise->save();
    }
}
