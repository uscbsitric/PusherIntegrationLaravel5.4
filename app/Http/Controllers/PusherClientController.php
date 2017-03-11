<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PusherClientController extends Controller
{
    public function pusherClient()
    {
    	return view('pusherClient');
    }
}
