<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TicketController extends Controller
{
    public function createTicket($premise_id, $activity_id) {
    	// generate ticket

    	// expect: premise_id and activity_id
    	// return: count based on today users count on that activity
    }
}
