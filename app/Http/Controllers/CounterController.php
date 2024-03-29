<?php

namespace App\Http\Controllers;

use App\Premise;
use App\Activity;
use App\Counter;
use App\Kiosk;
use App\Ticket;

use Carbon\Carbon;

use App\Http\Controllers\TicketController;

use Illuminate\Http\Request;

use App\Http\Requests;

class CounterController extends Controller
{

	public function index() {
		return view('kiosk.get');
	}

	public function index_process(Request $request) {
		$id = $request->input('invite');

		if ($id) {
			//die($id);
			if ($ticket = Ticket::where('invite', $id)->first()) {
				//die('heh');
				return redirect('/ticket/'.$ticket->id);
			}
		}

		return view('kiosk.get');
	}

	/*
		public function index_process(Request $request) {
		$id = $request->input('id');

		if ($ticket = Ticket::find($id)) {
			die)
			return redirect('/ticket/'.$ticket->id);
		}

		return view('kiosk.get');
	}
	*/
    public function viewCounter($counter_id) {
    	// get last the most early linked to the activity based on queue_id

    	if (!$counter = Counter::find($counter_id)) {
    		return 'err_no_counter';
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


		$current = Ticket::where('serving_counter', $counter_id)->orderBy('updated_at', 'desc')->first();
		$current_serve = $current->activity_id . str_pad($current->queue_id, 3, "0", STR_PAD_LEFT);
    	return view('kiosk.counter')->with(['current' => $counter, 'list' => $full_list, 'current_serve' => $current_serve]);
    }

    public function pickTicketToCounter($counter_id, $ticket_id) {

    	if (!$counter = Counter::find($counter_id)) {
    		return 'err_no_counter';
    	}


    	if (!$ticket = Ticket::find($ticket_id)) {
    		return 'err_no_ticket';
    	}

    	if ($ticket->served) {
    		return 'err_already_served';
    	}

    	$serving = json_decode($counter->activity_enabled);


    	if (!in_array($ticket->activity_id, $serving)) {
    		return 'err_not_activity_target';
    	}

    	$ticket->served = true;
    	$ticket->serving_counter = $counter_id;
    	$ticket->served_time = Carbon::now();

    	$ticket->update();

    	// play music

        $fp = stream_socket_client("tcp://localhost:13372", $errno, $errstr, 30);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            fwrite($fp, json_encode(['action' => 'callNumber', 'number' => $ticket->activity_id. str_pad($ticket->queue_id, 3, "0", STR_PAD_LEFT), 'counter' => $counter->id]));
            fclose($fp);
        }

        return redirect('/counter/'. $counter_id);
    }


    public function markDownTicketCounter($counter_id, $ticket_id) {

    	if (!$counter = Counter::find($counter_id)) {
    		return 'err_no_counter';
    	}


    	if (!$ticket = Ticket::find($ticket_id)) {
    		return 'err_no_ticket';
    	}

    	if ($ticket->done) {
    		return 'err_already_done';
    	}

    	$serving = json_decode($counter->activity_enabled);


    	if (!in_array($ticket->activity_id, $serving)) {
    		return 'err_not_activity_target';
    	}

    	$ticket->done = true;
    	$ticket->done_time = Carbon::now();

    	$ticket->update();
    }
}

