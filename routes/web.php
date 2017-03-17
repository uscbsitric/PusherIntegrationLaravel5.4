<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/bridge',
			function()
			{
			  $pusher = App::make('pusher');
              $pusher->trigger('test-channel',
                               'test-event',
                               array('text' => 'Preparing the Pusher Laracon.cebu workshop!')
              		          );
              
              exit('testing Pusher Integration with Laravel 5.4');
	        }
	      );

Route::get('/pusherClient',
		   'PusherClientController@pusherClient'
		  );

Route::get('/notifications/index',
		  'PusherClientController@index'
		 );

Route::post('/notifications/notify',
		    'PusherClientController@notify'
		   );


Route::get('/auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('/auth/github/callback', 'Auth\AuthController@handleProviderCallback');

Route::get('/activities', 
		   'ActivityController@index'
		  );

Route::post('/activities/status-update',
		    'ActivityController@statusUpdate'
		   );