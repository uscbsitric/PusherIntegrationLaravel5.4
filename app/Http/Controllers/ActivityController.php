<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App;

class ActivityController extends Controller
{
    public $pusher;
    public $user;

    public function __construct()
    {
    	// resolve('pusher') // try and swap this with line 17 code
        $this->pusher = App::make('pusher');
        $this->user = Session::get('user'); // by having a user, we can identify who has triggered an activity event
    }

    /**
     * GET
     * Serve the example activities view
     */
    public function index()
    {
        // If there is no user, redirect to GitHub login
        if(!$this->user)
        {
            return redirect('auth/github?redirect=/activities');
        }
        
        $user = $this->user; // debuggin purposes only

        // TODO: provide some useful text
        $activity = ['text' => 'GitHub User: ',
                     'username' => $this->user->getNickname(),
                     'avatar' => $this->user->getAvatar(),
                     'id' => str_random()
                    ];

        // TODO: trigger event
        $this->pusher->trigger('notifications', //channel
        		               'new-notification', // event  // On the 'notifications' channel trigger a 'new-notification' event
        		               $activity
        		              );

        return view('activities');
    }

    /**
     * POST
     * A new status update has been posted
     * @param Request $request
     */
    public function statusUpdate(Request $request)
    {
        $statusText = $request['status_text'];

        // TODO: trigger event
        $this->pusher->trigger('notifications', //channel
        		               'new-notification', // event  // On the 'notifications' channel trigger a 'new-notification' event
        		               array('text' => $statusText)
        		              );
    }

    /**
     * POST
     * Like an exiting activity
     * @param $id The ID of the activity that has been liked
     */
    public function like($id)
    {
        // TODO: trigger event
    	$this->pusher->trigger('notifications', //channel
    			               'new-notification', // event  // On the 'notifications' channel trigger a 'new-notification' event
    			               array('text' => 'someone with ID: ' . $id . ' likes this.' )
    			              );
    }
}