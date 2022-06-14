<?php namespace Xenon\MultiCourier;

use Exception;

class MultiCourier
{
    /** @var Courier */
    private $courier;

    /**
     * @param Courier $sender
     * @version v1.0.1
     * @since v1.0.1
     */
    public function __construct(Courier $sender)
    {
        $this->courier = $sender;
    }

    /**
     * @throws Handler\ErrorException
     * @throws Exception
     * @version v1.0.1
     * @since v1.0.1
     */
    public function via($provider): MultiCourier
    {
        $this->courier->setProvider($provider);
        $this->courier->setConfig(config('multicourier.providers')[$provider]);
        return $this;
    }

}
