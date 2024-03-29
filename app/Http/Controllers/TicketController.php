<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Premise;
use App\Activity;
use App\Counter;
use App\Kiosk;
use App\Ticket;

class TicketController extends Controller
{

	public function view($id) {
		if (!$ticket = Ticket::find($id)) {
			return redirect('/');
		}

		$last_ticket = Ticket::where('served', true)->where('done', false)->orderBy('queue_id', 'desc')->first();
		$current_ticket = $ticket->activity_id . " ". str_pad($ticket->queue_id, 3, "0", STR_PAD_LEFT);

		return view('kiosk.view')->with(['current_ticket' => $last_ticket->activity_id . str_pad($last_ticket->queue_id, 3, "0", STR_PAD_LEFT), 'your_ticket' => $current_ticket]);

	}

    public function createTicket($activity_id) {
    	// generate ticket

    	// expect: premise_id and activity_id
    	// return: count based on today users count on that activity
    	// [activity_id]0000[count_id rounded of to base 10

    	// (activity_id)<count with leading 3 zeros> 
    	// count by days

    	if (!$activity = Activity::where('id', $activity_id)->first()) {
    		return 'err_no_activity';
    	}

    	if ($ticket = Ticket::where('activity_id', $activity_id)->where('created_at', 'like', date('Y-m-d').' %' )->orderBy('queue_id', 'desc')->first()) {

    		if ($ticket->queue_id == 999) {
    			return 'err_ticket_ran_out';

    		}

            $old = ($ticket->queue_id + 1);
    		// get ticket
    		$ticket = new Ticket;
    		$ticket->premise_id = $activity->premise_id;
    		$ticket->activity_id = $activity_id;
    		$ticket->queue_id = $old;
    		$ticket->invite = "" + rand(0,9) . rand(0,9) ."-".rand(0,9) . rand(0,9).rand(0,9) ."-".rand(0,9).rand(0,9);
    		//$ticket_new->finished_at = false;
    		$ticket->save();
    	} else {
    		// first time create ticket

    		$ticket = new Ticket;
    		$ticket->premise_id = $activity->premise_id;
    		$ticket->activity_id = $activity->id;
    		$ticket->queue_id = 0;
    		$ticket->invite = "" + rand(0,9) . rand(0,9) ."-".rand(0,9) . rand(0,9).rand(0,9) ."-".rand(0,9).rand(0,9);
    		//$ticket_new->finished_at = false;
    		$ticket->save();
    	}

    	$ticket_id = $activity_id . str_pad($ticket->queue_id, 3, "0", STR_PAD_LEFT);

    	$premise = Premise::find($ticket->premise_id);
    	$get_current = Ticket::where('done', false)->where('served', false)->where('premise_id', $premise->id)->where('activity_id', $ticket->activity_id)->where('created_at', 'like', date('Y-m-d').' %' )->orderBy('queue_id', 'asc')->first();

    	if ($get_current) {
    		$current_number = $activity_id . str_pad($get_current->queue_id, 3, "0", STR_PAD_LEFT);
    	} else {
    		$current_number = "none";
    	}

        // return ticket info
        $fp = stream_socket_client("tcp://localhost:13372", $errno, $errstr, 30);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            fwrite($fp, json_encode(['action' => 'printNumber', 'premise_name' => $premise->name, 'desc' => $premise->desc, 'current_number' => $current_number, 'user_number' => $ticket_id, 'estimated_time' => '12:51 AM', 'queue_id' => $ticket->invite, 'gen_time' => date('Y-m-d h:i:s')]));
            fclose($fp);
        }

        return redirect('/kiosk');
        //return response()->json(['ticket_id' => $ticket_id, 'premise_id' => $ticket->premise_id, 'activity_id' => $ticket->activity_id, 'datetime' => $ticket->created_at]);
    }

    public static function getTicketETA($premise_id = 1, $activity_id = 4) {
    	// generate ticket

    	// expect: premise_id and activity_id
    	// return: count based on today users count on that activity
    	// [activity_id]0000[count_id rounded of to base 10

    	// (activity_id)<count with leading 3 zeros> 
    	// count by days

    	if (!Premise::find($premise_id)) {
    		return false;
    	}

    	if (!$activity = Activity::where('id', $activity_id)->where('premise_id', $premise_id)->first()) {
    		return false;
    	}

    	// get la
    	$queue_list = Ticket::where('done', false)->where('served', false)->where('premise_id', $premise_id)->where('activity_id', $activity_id)->where('created_at', 'like', date('Y-m-d').' %' )->orderBy('queue_id', 'asc')->get();
    	//return response()->json($queue_list);

    	$list = [];

    	foreach ($queue_list as $queue) {
    		$list[] = ['id' => $queue->id, 'activity_id' => $queue->activity_id, 'queue' => $activity_id . str_pad($queue->queue_id, 3, "0", STR_PAD_LEFT), 'started' => $queue->created_at, 'waiting_time' => humanTiming(strtotime($queue->created_at)), 'time' => strtotime($queue->created_at)];
    	}

    	return $list;
    }

    public function listActivity($premise_id = 1) {

    	if (!Premise::find($premise_id)) {
    		return false;
    	}

    	$activities = Activity::where('premise_id', $premise_id)->get();

    	return response()->json($activities);
    }
}


function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}