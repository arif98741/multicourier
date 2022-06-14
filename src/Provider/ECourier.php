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
use Xenon\MultiCourier\Handler\ErrorException;
use Xenon\MultiCourier\Handler\ParameterException;
use Xenon\MultiCourier\Handler\RequestException;
use Xenon\MultiCourier\Request;

class ECourier extends AbstractProvider
{
    /**
     * @var string
     */
    private $base_url = 'https://staging.ecourier.com.bd/api/';
    /**
     * @var mixed|string
     */
    private $environment;

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
     * @throws GuzzleException
     * @throws RequestException
     * @deprecated
     * Send Request To Api and Send Message
     */
    public function sendRequest()
    {
        $endpoint = $this->senderObject->getRequestEndpoint();
        $request = new Request($this->getBaseUrl(), $endpoint, 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
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
     * @return array
     */
    private function getHeaderConfig(): array
    {
        $providerConfiguration = $this->senderObject->getConfig();

        return [
            'API-KEY' => $providerConfiguration['API-KEY'],
            'API-SECRET' => $providerConfiguration['API-SECRET'],
            'USER-ID' => $providerConfiguration['USER-ID'],
        ];
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
    public function getAreas(): Request
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter postcode missing for getting area. Use setParams() for setting parameters ');
        }
        if (count($params) == 0 || !array_key_exists('postcode', $params)) {
            throw new ParameterException('Parameter postcode missing for getting area.');
        }

        $request = new Request($this->getBaseUrl(), 'area-list', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        return $request->executeRequest();
    }

    /**
     * @throws GuzzleException
     * @throws RequestException
     * @throws ParameterException
     */
    public function getPostCodes(): Request
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter city or thana missing for getting area. Use setParams() for setting parameters ');
        }
        if (count($params) == 0 || !array_key_exists('city', $params) || !array_key_exists('thana', $params)) {
            throw new ParameterException('Parameter city or thana missing for getting area.');
        }

        $request = new Request($this->getBaseUrl(), 'postcode-list', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        return $request->executeRequest();
    }

    /**
     * @throws GuzzleException
     * @throws RequestException
     */
    public function getBranches(): Request
    {
        $request = new Request($this->getBaseUrl(), 'branch-list', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        return $request->executeRequest();
    }

    /**
     * @throws GuzzleException
     * @throws RequestException
     * @throws ParameterException
     */
    public function printLabel(): Request
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter tracking missing for print label. Use setParams() for setting parameters ');
        }
        if (count($params) == 0 || !array_key_exists('tracking', $params)) {
            throw new ParameterException('Parameter tracking missing for print label');
        }

        $request = new Request($this->getBaseUrl(), 'label-print', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
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
     * @throws ParameterException
     */
    public function trackChildOrder(): Request
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter Ecr missing for tracking order. Use setParams() for setting parameters ');
        }
        if (count($params) == 0 || !array_key_exists('Ecr', $params)) {
            throw new ParameterException('Parameter Ecr missing for tracking order.');
        }

        $request = new Request($this->getBaseUrl(), 'track-child', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
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
     * @return Request
     * @throws ParameterException
     * @throws ErrorException
     */
    function placeOrder()
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter data array missing for placing order. Use setParams() for setting parameters ');
        }
        if (count($params) == 0) {
            throw new ParameterException('Parameter ecr missing for placing order.');
        }

        $request = new Request($this->getBaseUrl(), 'order-place', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        try {
            return $request->executeRequest();
        } catch (GuzzleException|RequestException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * @return Request
     * @throws ParameterException
     * @throws ErrorException
     */
    function cancelOrder()
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter data array missing for cancelling order. Use setParams() for setting parameters ');
        }
        if (count($params) == 0 || !array_key_exists('tracking', $params)) {
            throw new ParameterException('Parameter tracking missing for cancelling order.');
        }

        $request = new Request($this->getBaseUrl(), 'cancel-order', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        try {
            return $request->executeRequest();
        } catch (GuzzleException|RequestException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * @return Request
     * @throws ParameterException
     * @throws ErrorException
     */
    function cancelChildOrder()
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter data array missing for child cancelling order. Use setParams() for setting parameters ');
        }
        if (count($params) == 0 || !array_key_exists('tracking', $params)) {
            throw new ParameterException('Parameter tracking missing for cancelling order.');
        }

        $request = new Request($this->getBaseUrl(), 'cancel-order-child', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        try {
            return $request->executeRequest();
        } catch (GuzzleException|RequestException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * @return Request
     * @throws ParameterException
     * @throws ErrorException
     */
    function fraudStatusCheck(): Request
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter data array missing for checking fraud. Use setParams() for setting parameters ');
        }
        if (count($params) == 0 || !array_key_exists('number', $params)) {
            throw new ParameterException('Parameter number missing for checking fraud.');
        }

        $request = new Request($this->getBaseUrl(), 'fraud-status-check', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        try {
            return $request->executeRequest();
        } catch (GuzzleException|RequestException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * @return Request
     * @throws ParameterException
     * @throws ErrorException
     */
    function boostSms(): Request
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter data array missing for boosting sms. Use setParams() for setting parameters ');
        }

        $request = new Request($this->getBaseUrl(), 'bs-sms', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        try {
            return $request->executeRequest();
        } catch (GuzzleException|RequestException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * @return Request
     * @throws ParameterException
     * @throws ErrorException
     */
    function topupSms(): Request
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter data array missing for top up. Use setParams() for setting parameters ');
        }

        $request = new Request($this->getBaseUrl(), 'bs-top', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        try {
            return $request->executeRequest();
        } catch (GuzzleException|RequestException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * @return Request
     * @throws ParameterException
     * @throws ErrorException
     */
    function topupOtp(): Request
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter data array missing for tracking order. Use setParams() for setting parameters ');
        }

        $request = new Request($this->getBaseUrl(), 'bs-top-otp', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        try {
            return $request->executeRequest();
        } catch (GuzzleException|RequestException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * @return Request
     * @throws ParameterException
     * @throws ErrorException
     */
    function topTransactionStatus(): Request
    {
        $params = $this->senderObject->getParams();
        if (!is_array($params)) {
            throw new ParameterException('Parameter data array missing for tracking order. Use setParams() for setting parameters ');
        }
        if (count($params) == 0 || !array_key_exists('transaction_id', $params)) {
            throw new ParameterException('Parameter transaction_id missing for checking top up status order.');
        }

        $request = new Request($this->getBaseUrl(), 'bs-top-status', 'post', $this->getHeaderConfig(), $this->senderObject->getParams());
        try {
            return $request->executeRequest();
        } catch (GuzzleException|RequestException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * @return void
     */
    function getOrders()
    {
        // TODO: Implement getOrders() method.
    }

    public function authorize()
    {
        // TODO: Implement authorize() method.
    }
}
