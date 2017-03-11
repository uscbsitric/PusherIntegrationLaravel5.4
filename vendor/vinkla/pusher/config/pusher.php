<?php

/*
 * This file is part of Laravel Pusher.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Pusher Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
      PUSHER_KEY=a055338bda4b8d846dfc
      PUSHER_SECRET=f790d5cad6ce3861e970
      PUSHER_APP_ID=305756
    */

    'connections' => [

        'main' => [
            'auth_key' => 'a055338bda4b8d846dfc',
            'secret' => 'f790d5cad6ce3861e970',
            'app_id' => '305756',
            'options' => ['cluster' => 'ap1',
            		      'ecnrypted' => true 
                         ],
            'host' => null,
            'port' => null,
            'timeout' => null,
        ],

        'alternative' => [
            'auth_key' => 'a055338bda4b8d846dfc',
            'secret' => 'f790d5cad6ce3861e970',
            'app_id' => '305756',
            'options' => ['cluster' => 'ap1',
            		      'ecnrypted' => true
                         ],
            'host' => null,
            'port' => null,
            'timeout' => null,
        ],

    ],

];
