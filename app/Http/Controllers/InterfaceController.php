<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class InterfaceController extends Controller
{
    public function number() {
        $fp = stream_socket_client("tcp://localhost:13372", $errno, $errstr, 30);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            fwrite($fp, json_encode(['action' => 'callNumber', 'number' => 1023, 'counter' => 5]));
            fclose($fp);
        }
    }
}
