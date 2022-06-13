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
use Xenon\MultiCourier\Handler\RequestException;
use Xenon\MultiCourier\Request;

class ECourier extends AbstractProvider
{
    /**
     * @var string
     */
    private string $base_url = 'https://staging.ecourier.com.bd/api/';
    /**
     * @var mixed|string
     */
    private string $environment;

    /**
     * ECourier constructor.
     * @param Courier $courier
     * @param string $environment
     * @throws ParameterException
     */
    public function __construct(Courier $courier, string $environment = 'local')
    {
        $this->senderObject = $courier;
        $this->errorException();

        if ($this->senderObject->environment == 'production') {
            $this->setBaseUrl('https://backoffice.ecourier.com.bd/api/');
        }

    }

    /**
     * @throws GuzzleException
     * @throws RequestException
     * @deprecated
     * Send Request To Api and Send Message
     */
    public function sendRequest()
    {
        $endpoint = $this->senderObject->getRequestEndpoint();
        $providerConfiguration = config('courier')['providers'][get_class($this)];
        $headerConfig = [
            'API-KEY' => $providerConfiguration['API-KEY'],
            'API-SECRET' => $providerConfiguration['API-SECRET'],
            'USER-ID' => $providerConfiguration['USER-ID'],
        ];

        $request = new Request($this->getBaseUrl(), $endpoint, 'post', $headerConfig, $this->senderObject->getParams());
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
        if (!array_key_exists('API-KEY', $this->senderObject->getConfig())) {
            throw new ParameterException('API-KEY key is absent in configuration');
        }

        if (!array_key_exists('API-SECRET', $this->senderObject->getConfig())) {
            throw new ParameterException('API-SECRET key is absent in configuration');
        }

        if (!array_key_exists('USER-ID', $this->senderObject->getConfig())) {
            throw new ParameterException('USER-ID key is absent in configuration');
        }

    }

    /**
     * @throws GuzzleException
     * @throws RequestException
     */
    public function getCities(): Request
    {
        $request = new Request($this->getBaseUrl(), 'city-list', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        return $request->executeRequest();
    }


    /**
     * @throws GuzzleException
     * @throws RequestException
     * @throws ParameterException
     */
    public function getThanas(): Request
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter city missing for getting thana. Use setParams() for setting parameters ');
        }
        if (count($params) == 0 || !array_key_exists('city', $params)) {
            throw new ParameterException('Parameter city missing for getting thana.');
        }

        $request = new Request($this->getBaseUrl(), 'thana-list', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        return $request->executeRequest();
    }

    /**
     * @throws GuzzleException
     * @throws RequestException
     * @throws ParameterException
     */
    public function trackOrder(): Request
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter ecr missing for tracking order. Use setParams() for setting parameters ');
        }
        if (count($params) == 0 || !array_key_exists('ecr', $params)) {
            throw new ParameterException('Parameter ecr missing for tracking order.');
        }

        $request = new Request($this->getBaseUrl(), 'track', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        return $request->executeRequest();
    }

    /**
     * @throws GuzzleException
     * @throws RequestException
     */
    public function getPackages(): Request
    {
        $request = new Request($this->getBaseUrl(), 'packages', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        return $request->executeRequest();
    }


    /**
     * @return mixed
     * @throws ParameterException
     */
    function placeOrder()
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter data array missing for tracking order. Use setParams() for setting parameters ');
        }
        if (count($params) == 0) {
            throw new ParameterException('Parameter ecr missing for tracking order.');
        }

        $request = new Request($this->getBaseUrl(), 'order-place', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        return $request->executeRequest();
    }

    /**
     * @return mixed
     */
    function getOrders()
    {
        // TODO: Implement getOrders() method.
    }

    public function authorize()
    {
        // TODO: Implement authorize() method.
    }


    /**
     * @return array
     */
    private function getHeaderConfig(): array
    {
        $providerConfiguration = $this->senderObject->getConfig();

        $headerConfig = [
            'API-KEY' => $providerConfiguration['API-KEY'],
            'API-SECRET' => $providerConfiguration['API-SECRET'],
            'USER-ID' => $providerConfiguration['USER-ID'],
        ];
        return $headerConfig;
    }
}
