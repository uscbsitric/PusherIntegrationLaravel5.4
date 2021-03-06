<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller
{
    var $pusher;
    var $user;
    var $chatChannel;

    //const DEFAULT_CHAT_CHANNEL = 'chat';
    const DEFAULT_CHAT_CHANNEL = 'private-chat';

    public function __construct()
    {
        $this->pusher = App::make('pusher');
        $this->chatChannel = self::DEFAULT_CHAT_CHANNEL;
    }

    /*****
     * GET
     *****/
    public function index()
    {
    	$this->user = session('githubUser');

        if(!$this->user)
        {
          return redirect('auth/github?redirect=/chat');
        }

        return view('chat', ['chatChannel' => $this->chatChannel]);
    }

    /*****
     * POST
     * @param Request $request
     */
    public function message(Request $request)
    {
    	$this->user = session('githubUser');
    	
    	if(!$this->user)
    	{
    		return redirect('auth/github?redirect=/chat');
    	}

        $message = ['text' => $request['chat_text'],
                    'username' => $this->user->getNickname(),
                    'avatar' => $this->user->getAvatar(),
                    'timestamp' => (time()*1000)
                   ];

        $this->pusher->trigger($this->chatChannel, // channel 
        		              'new-message',       // event
        		               $message            // data
        		              );
    }
    
    /*****
     * POST
     * @param Request $request
     */
    public function auth(Request $request)
    {
    	$this->user =session('githubUser');
    	
    	if(!$this->user)
    	{
    		return redirect('auth/github?redirect=/chat');
    	}
    	
    	$socketID = $request['socket_id'];
    	$channelName = $request['channel_name'];
    	
        $message = ['text' => $request['chat_text'],
                    'username' => $this->user->getNickname(),
                    'avatar' => $this->user->getAvatar(),
                    'timestamp' => (time()*1000)
                   ];

        $authorizeMe = $this->pusher->socket_auth($channelName, $socketID);
        $this->pusher->trigger($this->chatChannel, // channel 
        		               'new-message',      // event
        		                $message           // data
        		              );
        
        echo $authorizeMe;
    }
}