<?php namespace Xenon\MultiCourier\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static Xenon\MultiCourier\Log\Log createLog(array $data)
 * @method static Xenon\MultiCourier\Log\Log viewLastLog()
 * @method static Xenon\MultiCourier\Log\Log viewAllLog()
 * @method static Xenon\MultiCourier\Log\Log logByProvider()
 * @method static Xenon\MultiCourier\Log\Log logByDefaultProvider()
 * @method static Xenon\MultiCourier\Log\Log total()
 * @method static Xenon\MultiCourier\Log\Log toArray()
 * @method static Xenon\MultiCourier\Log\Log toJson()
 *
 * @see \Xenon\MultiCourier\Log\Log
 */
class Logger extends Facade
{
    /**
     * @return string
     * @version v1.0.35
     * @since v1.0.35
     */
    protected static function getFacadeAccessor(): string
    {
        return 'LaravelBDSmsLogger';
    }
}
