<?php namespace Xenon\MultiCourier\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Xenon\MultiCourier\MultiCourier via(string $provider)
 *
 * @see \Xenon\MultiCourier\MultiCourier
 */
class MultiCourier extends Facade
{
    /**
     * @return string
     * @version v1.0.1
     * @since v1.0.1
     */
    protected static function getFacadeAccessor(): string
    {
        return 'MultiCourier';
    }
}
