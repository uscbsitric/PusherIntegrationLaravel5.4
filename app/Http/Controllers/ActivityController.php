<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
    public $pusher;
    public $user;

    /*****
    public function __construct(Request $request)
    {
    	$this->pusher = resolve('pusher'); // try and swap this with line 17 code
        //$this->pusher = App::make('pusher');
        //$this->user = $request->session()->get('user'); // by having a user, we can identify who has triggered an activity event
    	//$testVariable4 = $request->session()->get('user2');
        $testVariable1 = Session::get('user1');
        $testVariable2 = Session::get('user2');
        $testVariable3 = Session::get('user3');
        $testVariable4 = session('user1');
        $testVariable5 = session('user2');
        $testVariable6 = session('user3');
        
        echo "<pre>";
        var_dump( array($testVariable1,
        		        $testVariable2,
        		        $testVariable4,
        		        $testVariable5,
        		        $testVariable6,
        		        $request->session()->all()
                       ) 
        		);
        exit();
    }
    *****/

    public function test()
    {
    	$testVariable1 = Session::get('user1');
    	$testVariable2 = Session::get('user2');
    	$testVariable3 = Session::get('user3');
    	$testVariable4 = session('user1');
    	$testVariable5 = session('user2');
    	$testVariable6 = session('user3');
    	
    	echo "<pre>";
    	var_dump( array($testVariable1,
    			        $testVariable2,
    			        $testVariable4,
    			        $testVariable5,
    			        $testVariable6
    	               )
    			);
    	exit();
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
            return redirect('/auth/github?redirect=/activities');
        }
        
        $user = $this->user; // debuggin purposes only

        // TODO: provide some useful text
        $activity = ['text' => 'GitHub User: ',
                     'username' => $this->user->getNickname(),
                     'avatar' => $this->user->getAvatar(),
                     'id' => str_random()
                    ];

		var_dump($activity);
        exit('');

        /*****
        // TODO: trigger event
        $this->pusher->trigger('notifications', //channel
        		               'new-visit',     // event  // On the 'notifications' channel trigger a 'new-notification' event
        		               $activity
        		              );

        return view('activities');
        *****/
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
        $this->pusher->trigger('notifications',       // channel
        		               'status-update-event', // event  // On the 'notifications' channel trigger a 'new-notification' event
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
    			               'like-event',    // event  // On the 'notifications' channel trigger a 'new-notification' event
    			               array('text' => 'someone with ID: ' . $id . ' likes this.' )
    			              );
    }
}