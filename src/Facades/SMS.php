<?php namespace Xenon\MultiCourier\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Xenon\MultiCourier\SMS via(string $provider)
 * @method static mixed shoot(string $mobile, string $text)
 *
 * @see \Xenon\MultiCourier\SMS
 */
class SMS extends Facade
{
    /**
     * @return string
     * @version v1.0.32
     * @since v1.0.31
     */
    protected static function getFacadeAccessor(): string
    {
        return 'LaravelBDSms';
    }
}
