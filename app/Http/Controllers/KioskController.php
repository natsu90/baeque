<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Activity;
use App\Http\Requests;

class KioskController extends Controller
{
    public function index() {
    	return view('kiosk.index')->with(['list' => Activity::get()]);
    }

    
}
