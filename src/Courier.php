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
     * @var AbstractProvider
     */
    private $provider;
    /**
     * @var
     */
    /**
     * @var
     */
    public $requestEndpoint;

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

    public $environment = 'local';

    /**
     * @var
     */
    private $method;

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
     * @var null
     */
    private static $instance = null;


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
     * Send Message Finally
     * @since v1.0.5
     */
    public function send()
    {

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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return Courier
     * @since v1.0.0
     */
    public function setMessage($message = ''): Courier
    {
        $this->message = $message;
        return self::getInstance();
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
     * @param $ProviderClass
     * @param string $environment
     * @return Courier
     * @throws ErrorException
     * @since v1.0.0
     */
    public function setProvider($ProviderClass, string $environment = 'local'): Courier
    {

        try {
            if (!class_exists($ProviderClass)) {
                throw new ErrorException("Courier Provider $ProviderClass not found");
            }

            if (!is_subclass_of($ProviderClass, AbstractProvider::class)) {
                throw new ErrorException("Provider '$ProviderClass' is not a " . AbstractProvider::class);
            }

            $this->environment = $environment;

        } catch (ErrorException $exception) {

            throw new ErrorException($exception->getMessage());
        }


        $this->provider = $ProviderClass;

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
        if (!method_exists($providerObject, __FUNCTION__)) {
            throw new RequestException("Method " . __FUNCTION__ . " not exist in $this->provider class");
        }
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
        if (!method_exists($providerObject, __FUNCTION__)) {
            throw new RequestException("Method " . __FUNCTION__ . " not exist in $this->provider class");
        }
        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     * @since v1.0.1
     */
    public function trackOrder()
    {
        $providerObject = new $this->provider($this);

        if (!method_exists($providerObject, __FUNCTION__)) {
            throw new RequestException("Method " . __FUNCTION__ . " not exist in $this->provider class");
        }

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     * @since v1.0.1
     */
    public function getPackages()
    {
        $providerObject = new $this->provider($this);

        if (!method_exists($providerObject, __FUNCTION__)) {
            throw new RequestException("Method " . __FUNCTION__ . " not exist in $this->provider class");
        }

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @throws RequestException
     * @since v1.0.1
     */
    public function placeOrder()
    {
        $providerObject = new $this->provider($this);

        if (!method_exists($providerObject, __FUNCTION__)) {
            throw new RequestException("Method " . __FUNCTION__ . " not exist in $this->provider class");
        }

        return $providerObject->{__FUNCTION__}();
    }

    /**
     * @param $config
     * @param $response
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
                    'config' => $config['providers'][get_class($this->provider)],
                    'message' => $this->getMessage()
                ])
                ,
                'response_json' => json_encode($providerResponse)
            ]);
        }
    }

}
