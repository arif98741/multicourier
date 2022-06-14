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

use Exception;
use Xenon\MultiCourier\Facades\Logger;
use Xenon\MultiCourier\Handler\ErrorException;
use Xenon\MultiCourier\Handler\RequestException;
use Xenon\MultiCourier\Provider\AbstractProvider;

class Courier
{
    /**
     * @var null
     */
    private static $instance = null;
    /**
     * @var
     */
    public $requestEndpoint;
    /**
     * @var
     */
    public $environment = 'local';
    /**
     * @var AbstractProvider
     */
    private $provider;
    /**
     * @var
     */
    private $config;
    /**
     * @var
     */
    private $params;
    /**
     * @var
     */
    private $headers;
    /**
     * @var
     */
    private $method;

    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     * This implementation lets you subclass the Singleton class while keeping
     * just one instance of each subclass around.
     */
    public static function getInstance(): Courier
    {
        if (!isset(self::$instance)) {
            self::$instance = new Courier();
        }

        return self::$instance;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     * @return Courier
     * @throws Exception
     * @since v1.0.0
     */
    public function setConfig(array $config): Courier
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return void
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return void
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getRequestEndpoint()
    {
        return $this->requestEndpoint;
    }

    /**
     * This method accept request endpoint
     * @param mixed $requestEndpoint
     * @deprecated
     */
    public function setRequestEndpoint($requestEndpoint, array $params = []): void
    {
        $this->requestEndpoint = $requestEndpoint;
        if (!empty($params))
            $this->setParams($params);
    }


    /**
     * @return mixed
     * @since v1.0.0
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Return this class object
     * @param $providerClass
     * @param string $environment
     * @return Courier
     * @throws ErrorException
     * @since v1.0.0
     */
    public function setProvider($providerClass, string $environment = 'local'): Courier
    {

        try {
            if (!class_exists($providerClass)) {
                throw new ErrorException("Courier provider doesn't exist-  $providerClass");
            }

            if (!is_subclass_of($providerClass, AbstractProvider::class)) {
                throw new ErrorException("Provider $providerClass is not a " . AbstractProvider::class);
            }

            $this->environment = $environment;

        } catch (ErrorException $exception) {

            throw new ErrorException($exception->getMessage());
        }

        $this->provider = $providerClass;
        return $this;
    }

    /**
     * @return void
     * @throws RequestException
     * @since v1.0.1
     */
    public function getCities()
    {
        $providerObject = new $this->provider($this);
        $this->methodNotException($providerObject, __FUNCTION__);
        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @return mixed
     * @throws RequestException
     * @since v1.0.1
     */
    public function getThanas()
    {
        $providerObject = new $this->provider($this);
        $this->methodNotException($providerObject, __FUNCTION__);
        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     * @since v1.0.1
     */
    public function trackOrder()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     * @since v1.0.1
     */
    public function trackChildOrder()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     * @since v1.0.1
     */
    public function getPackages()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     * @since v1.0.1
     */
    public function placeOrder()
    {
        $providerObject = new $this->provider($this);
        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     * @since v1.0.1
     */
    public function cancelOrder()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     * @since v1.0.1
     */
    public function cancelChildOrder()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @return mixed
     * @throws RequestException
     */
    public function fraudStatusCheck()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @return mixed
     * @throws RequestException
     */
    public function getAreas()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @return mixed
     * @throws RequestException
     */
    public function getPostCodes()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     */
    public function getBranches()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     */
    public function printLabel()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }


    /**
     * @throws RequestException
     */
    public function boostSms()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     */
    public function topupSms()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @return mixed
     * @throws RequestException
     */
    public function topTransactionStatus()
    {
        $providerObject = new $this->provider($this);
        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @return mixed
     * @throws RequestException
     */
    public function topupOtp()
    {
        $providerObject = new $this->provider($this);

        $this->methodNotException($providerObject, __FUNCTION__);

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @param $config
     * @param $response
     * @deprecated
     */
    private function logGenerate($config, $response): void
    {
        if ($config['sms_log']) {


            if (is_object($response)) {
                $object = json_decode($response->getContent());
            } else {
                $object = json_decode($response);
            }

            $providerResponse = $object->response;

            Logger::createLog([
                'provider' => get_class($this->provider),
                'request_json' => json_encode([
                    'config' => $config['providers'][$this->provider],
                ])
                ,
                'response_json' => json_encode($providerResponse)
            ]);
        }
    }

    /**
     * @param $providerObject
     * @param $method
     * @return void
     * @throws RequestException
     */
    private function methodNotException($providerObject, $method): void
    {
        if (!method_exists($providerObject, $method)) {
            throw new RequestException("Method " . $method . " does not applicable for $this->provider class");
        }
    }
}
