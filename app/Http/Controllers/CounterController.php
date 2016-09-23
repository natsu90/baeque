<?php

namespace App\Http\Controllers;

use App\Premise;
use App\Activity;
use App\Counter;
use App\Kiosk;
use App\Ticket;

use App\Http\Controllers\TicketController;

use Illuminate\Http\Request;

use App\Http\Requests;

class CounterController extends Controller
{
    public function listCounterAction($counter_id = 1) {
    	// get last the most early linked to the activity based on queue_id

    	if (!$counter = Counter::find($counter_id)) {
    		return false;
    	}

    	$activity_enabled = json_decode($counter->activity_enabled);
    	$full_list = [];
    	foreach ($activity_enabled as $act) {
    		$list = TicketController::getTicketETA(1, $act);
    		foreach ($list as $item) {
    			array_push($full_list, $item);
    		}
    	}

		usort($full_list, function($a, $b) {
		    return $a['time'] - $b['time'];
		});

    	print_r($full_list);
    }
}

