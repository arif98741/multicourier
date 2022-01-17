<?php
/*
|--------------------------------------------------------------------------
| Configuration For Multiple Gateways
|--------------------------------------------------------------------------
|
| This file is key value a pair of providers. Individual provider has different types of
| params and api request params. This file is generated after running command below from your terminal.
| php artisan vendor:publish --provider="Xenon\\LaravelBDSmsLog\\LaravelBDSmsServiceProvider"
| .Here All data ar dynamically coming from .env file.
| Be sure to confirm to select default provider during use SMS facade, otherwise you can manually send sms
| by selecting provider.
| Happy coding !!!!!!!!!!!!
|
*/

use Xenon\MultiCourier\Provider\ECourier;

return [
    /*
     *-----------------------------------------------------------------------------------------------
     | This is a configuration file for default configuration of courier company
     | You Can change sms log to true or false according to your need. Default is true
     |---------------------------------------------------------------------------------------------
     */
    'sms_log' => true,

    /*
     *-----------------------------------------------------------------------------------------------
     | Default provider will be used during usage of facade ; Courier
     |---------------------------------------------------------------------------------------------
     */
    'default_provider' => env('COURIER_DEFAULT_PROVIDER', ECourier::class),
    'providers' => [

        ECourier::class => [
            'API-KEY' => env('ECOURIER_API-KEY', ''),
            'API-SECRET' => env('ECOURIER_API-SECRET', ''),
            'USER-ID' => env('ECOURIER_USER-ID', ''),
            'endpoints' => [
                'thana-list' => [
                    'method' => 'post',
                    'params' => ['city']
                ],
                'order-place' => [
                    'method' => 'post',
                    'params' => [
                    ]
                ],
            ]
        ],

    ]
];

