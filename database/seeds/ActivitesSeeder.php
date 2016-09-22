<?php

use App\Activity;
use Illuminate\Database\Seeder;

class ActivitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $list = [
        	["Bill Payment", "If you have bills to be paid, no matter whom you want to pay to."],
        	["Parcel Postage", "Need to post a parcel? No worries!"],
        	["Driving License Renewal", "Your driving license expired? Renew here!"],
        	["Claim Your Parcel", "Missed out a delivery? Your parcel is here? Get it now!"],
        ];

        foreach ($list as $item) {
	        $activity = new Activity;
	        $activity->premise_id = 1;
	        $activity->name = $item[0];
	        $activity->desc = $item[1];
	        $activity->save();
        }
    }
}
