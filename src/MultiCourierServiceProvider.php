<?php
/*
 *  Last Modified: 17/01/22, 15:48 PM
 *  Copyright (c) 2021
 *  -created by Ariful Islam
 *  -All Rights Preserved By
 *  -If you have any query then knock me at
 *  arif98741@gmail.com
 *  See my profile @ https://github.com/arif98741
 */

namespace Xenon\MultiCourier;

use Illuminate\Support\ServiceProvider;
use Xenon\MultiCourier\Log\Log;

class MultiCourierServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @version v1.0.32
     * @since v1.0.31
     */
    public function register()
    {
        $this->app->bind('MultiCourier', function () {

            $provider = config('sms.default_provider');

            $sender = Courier::getInstance();
            $sender->setProvider($provider);
            $sender->setConfig(config('sms.providers')[$provider]);
            return new SMS($sender);
        });

        $this->app->bind('MultiCourierLogger', function () {
            return new Log;
        });

        $this->app->bind('MultiCourierRequest', function () {
            return new Request;
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @version v1.0.32
     * @since v1.0.31
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/courier.php' => config_path('courier.php'),
        ]);


    }

}
