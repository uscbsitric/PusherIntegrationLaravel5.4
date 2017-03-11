<?php

/****
var_dump( array('key'    => env('PUSHER_KEY'),
		        'secret' => env('PUSHER_SECRET'),
		        'appID'  => env('PUSHER_APP_ID')
               )
		);
exit('frederick debugging here');
*****/

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'pusher'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
      PUSHER_KEY=a055338bda4b8d846dfc
      PUSHER_SECRET=f790d5cad6ce3861e970
      PUSHER_APP_ID=305756
    */

    'connections' => [

        'pusher' => ['driver' => 'pusher',
                     'key'    => env('PUSHER_KEY'),
                     'secret' => env('PUSHER_SECRET'),
                     'app_id' => env('PUSHER_APP_ID'),
                     'options' => ['cluster'   => 'ap1',
                     		       'encrypted' => true
                                  ],
                    ],

        'redis' => ['driver' => 'redis',
                    'connection' => 'default',
                   ],

        'log' => ['driver' => 'log',
                 ],

        'null' => ['driver' => 'null',
                  ],

    ],

];
