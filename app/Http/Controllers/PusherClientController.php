<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class PusherClientController extends Controller
{
    public function pusherClient()
    {
    	return view('pusherClient');
    }
    
    public function index()
    {
    	return view('notification');
    }
    
    public function notify(Request $request)
    {
    	$notifyText = $request['notify_text'];

    	// Get Pusher Instance from service container
    	//$pusher = App::make('pusher');  // working line of code
    	$pusher = resolve('pusher'); // as per Laravel 5.4 documentation

    	// The Notification event data should have a property named 'text'
    	$pusher->trigger('notifications', //channel
    			         'new-notification', // event  // On the 'notifications' channel trigger a 'new-notification' event
    			         array('text' => $notifyText)
    			        );

    }
}
