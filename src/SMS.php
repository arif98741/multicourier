<?php namespace Xenon\MultiCourier;

use Exception;

class SMS
{
    /** @var Courier */
    private $sender;

    /**
     * @param Courier $sender
     * @version v1.0.32
     * @since v1.0.31
     */
    public function __construct(Courier $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @throws Handler\ErrorException
     * @throws Exception
     * @version v1.0.32
     * @since v1.0.31
     */
    public function via($provider): SMS
    {
        $this->sender->setProvider($provider);
        $this->sender->setConfig(config('sms.providers')[$provider]);
        return $this;
    }

    /**
     * @throws Handler\ParameterException
     * @throws Handler\ValidationException
     * @throws Exception
     * @version v1.0.32
     * @since v1.0.31
     */
    public function shoot(string $number, string $text)
    {
        $this->sender->setMobile($number);
        $this->sender->setMessage($text);
        return $this->sender->send();
    }
}
