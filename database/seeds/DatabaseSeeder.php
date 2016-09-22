<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PremiseSeeder::class);
        $this->call(CountersSeeder::class);
        $this->call(ActivitesSeeder::class);
    }
}
