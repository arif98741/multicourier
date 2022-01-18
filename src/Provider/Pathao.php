<?php
/*
 *  Last Modified: 6/29/21, 12:06 AM
 *  Copyright (c) 2021
 *  -created by Ariful Islam
 *  -All Rights Preserved By
 *  -If you have any query then knock me at
 *  arif98741@gmail.com
 *  See my profile @ https://github.com/arif98741
 */

namespace Xenon\MultiCourier\Provider;

use GuzzleHttp\Exception\GuzzleException;
use Xenon\MultiCourier\Courier;
use Xenon\MultiCourier\Handler\ParameterException;
use Xenon\MultiCourier\Handler\RenderException;
use Xenon\MultiCourier\Handler\RequestException;
use Xenon\MultiCourier\Request;

class Pathao extends AbstractProvider
{
    /**
     * @var string
     */
    private $base_url = 'http://hermes-api.p-stageenv.xyz/aladdin/api/v1';
    /**
     * @var mixed|string
     */
    private $environment;

    /**
     * ECourier constructor.
     * @param Courier $sender
     * @param string $environment
     */
    public function __construct(Courier $sender, string $environment = 'local')
    {
        $this->senderObject = $sender;

        if ($this->senderObject->environment == 'production') {
            $this->setBaseUrl('https://api-hermes.pathaointernal.com/aladdin/api/v1');
        }
    }

    /**
     * Send Request To Api and Send Message
     * @throws GuzzleException
     * @throws ParameterException|RequestException
     * @throws RenderException
     */
    public function sendRequest()
    {
        $endpoint = $this->senderObject->getRequestEndpoint();
        $config = $this->senderObject->getConfig();
        $courierConfig = config('courier');
        if ($courierConfig == null) {
            throw new RenderException("No courier.php file exist inside config directory. You should publish vendor Xenon\MultiCourier\MultiCourierServiceProvider");
        }

        $providerConfiguration = config('courier')['providers'][get_class($this)];

        if (!array_key_exists($endpoint, $providerConfiguration['endpoints'])) {
            throw new ParameterException("Endpoint $endpoint doesn't exist for " . self::class);
        }

        $endpointData = $providerConfiguration['endpoints'][$endpoint];
        $request = new Request($this->getBaseUrl(), $endpoint, $endpointData['method'], $config, $this->senderObject->getParams());
        return $request->executeRequest();
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->base_url;
    }

    /**
     * @param string $base_url
     */
    public function setBaseUrl(string $base_url): void
    {
        $this->base_url = $base_url;
    }

    /**
     * @return mixed
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @param mixed $environment
     */
    public function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
    }

    /**
     * @throws ParameterException
     */
    public function errorException()
    {
        if (!array_key_exists('client_id', $this->senderObject->getConfig())) {
            throw new ParameterException('client_id key is absent in configuration');
        }

        if (!array_key_exists('client_secret', $this->senderObject->getConfig())) {
            throw new ParameterException('client_secret key is absent in configuration');
        }


        if (!array_key_exists('username', $this->senderObject->getConfig())) {
            throw new ParameterException('username key is absent in configuration');
        }

        if (!array_key_exists('password', $this->senderObject->getConfig())) {
            throw new ParameterException('password key is absent in configuration');
        }

        if (!array_key_exists('grant_type', $this->senderObject->getConfig())) {
            throw new ParameterException('grant_type key is absent in configuration');
        }


    }
}
