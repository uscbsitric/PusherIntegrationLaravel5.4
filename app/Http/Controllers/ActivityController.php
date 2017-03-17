<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
    public $pusher;
    public $user;

    public function __construct(Request $request)
    {
    	$this->pusher = resolve('pusher'); // try and swap this with line 17 code
        //$this->user = $request->session()->get('user'); // by having a user, we can identify who has triggered an activity event // sessions dont work in the constructor
    }

    /**
     * GET
     * Serve the example activities view
     */
    public function index()
    {
    	$githubUser = session('githubUser');
        // If there is no user, redirect to GitHub login
        if(!$githubUser)
        {
            return redirect('/auth/github?redirect=/activities');
        }

        // TODO: provide some useful text
        $activity = ['text' => 'GitHub User: ' . $githubUser->getNickname() . ' has visited the page.',
                     'username' => $githubUser->getNickname(),
                     'avatar' => $githubUser->getAvatar(),
                     'id' => $githubUser->user['email']
                    ];

        // TODO: trigger event
        $this->pusher->trigger('activities',   // channel
        		               'user-visit',   // event  // On the 'activities' channel trigger a 'user-visit' event
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
        $githubUser = session('githubUser');

        $activity = ['text' => $statusText,
        		     'username' => $githubUser->getNickname(),
        		     'avatar' => $githubUser->getAvatar(),
        		     'id' => $githubUser->user['email']
                    ];

        // TODO: trigger event
        $this->pusher->trigger('activities',        // channel
        		               'new-status-update', // event  // On the 'activities' channel trigger a 'new-status-update' event
                               $activity
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
    	$this->pusher->trigger('activities',             //channel
    			               'status-update-liked',    // event  // On the 'activities' channel trigger a 'status-update-liked' event
    			               array('text' => 'someone with ID: ' . $id . ' likes this.',
    			               		 'likedActivityId' => $id
    			                    )
    			              );
    }
}