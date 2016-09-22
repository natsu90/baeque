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
    public function createTicket($premise_id = 1, $activity_id = 4) {
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

    	if ($ticket = Ticket::where('premise_id', $premise_id)->where('activity_id', $activity_id)->where('created_at', 'like', date('Y-m-d').' %' )->orderBy('queue_id', 'desc')->first()) {

    		if ($ticket->queue_id == 999) {
    			return false;

    		}
    		// get ticket
    		$ticket_new = new Ticket;
    		$ticket_new->premise_id = $premise_id;
    		$ticket_new->activity_id = $activity_id;
    		$ticket_new->queue_id = ($ticket->queue_id + 1);
    		//$ticket_new->finished_at = false;
    		$ticket_new->save();

    		// return ticket info

    		return response()->json(['ticket_id' => $activity_id . str_pad($ticket_new->queue_id, 3, "0", STR_PAD_LEFT), 'premise_id' => $ticket->premise_id, 'activity_id' => $ticket->activity_id, 'datetime' => $ticket_new->created_at]);
    	} else {
    		// first time create ticket

    		$ticket = new Ticket;
    		$ticket->premise_id = $premise_id;
    		$ticket->activity_id = $activity_id;
    		$ticket->queue_id = 0;
    		//$ticket_new->finished_at = false;
    		$ticket->save();

    		// return ticket info

    		return response()->json(['ticket_id' => $activity_id . str_pad($ticket->queue_id, 3, "0", STR_PAD_LEFT), 'premise_id' => $ticket->premise_id, 'activity_id' => $ticket->activity_id, 'datetime' => $ticket->created_at]);
    	}


    }

    public function getTicketETA($premise_id = 1, $activity_id = 4) {
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
    	$queue_list = Ticket::where('done', false)->where('premise_id', $premise_id)->where('activity_id', $activity_id)->where('created_at', 'like', date('Y-m-d').' %' )->orderBy('queue_id', 'desc')->get(3);
    	print_r($queue_list);
    }


}
