<?php

namespace Xenon\MultiCourier;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use Xenon\MultiCourier\Handler\RequestException;

class Request
{
    /**
     * @var string
     */
    private $base_url;
    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var
     */
    public $response;

    /**
     * @var
     */
    private $method;

    /**
     * @var
     */
    public $statusCode;
    /**
     * @var
     */
    private $params;
    /**
     * @var array
     */
    private $headers;

    /**
     * @param $base_url
     * @param $endpoint
     * @param $method
     * @param array $headers
     * @param $params
     */
    public function __construct($base_url, $endpoint, $method, array $headers, $params)
    {
        $this->base_url = $base_url;
        $this->endpoint = $endpoint;
        $this->method = $method;
        $this->params = $params;
        $this->headers = $headers;
    }

    /**
     * @param false $verify
     * @throws GuzzleException
     * @throws RequestException
     */
    private function get($requestUrl, $query = [], bool $verify = false, $timeout = 10.0)
    {
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout' => $timeout,
        ]);

        try {
            return $client->request('GET', $requestUrl, [
                'query' => $query,
                'verify' => $verify,
                'headers' => $this->headers,
            ]);
        } catch (ConnectException $e) {
            throw new RequestException($e->getMessage());
        }


    }

    /**
     * @param false $verify
     * @throws GuzzleException
     * @throws RequestException
     */
    private function post($requestUrl, array $formParams = null, bool $verify = false)
    {
        $client = new Client([
            'base_uri' => $requestUrl,
            'timeout' => 10.0,
        ]);

        try {
            return $client->request('POST', '', [
                'form_params' => $formParams,
                'verify' => $verify,
                'headers' => $this->headers,
                'content-type' => 'application/json'
            ]);
        } catch (ConnectException|ClientException $e) {
            throw new RequestException($e->getMessage());
        }

    }

    /**
     * @throws GuzzleException
     * @throws RequestException
     */
    public function executeRequest(): Request
    {
        $requestUrl = $this->base_url . $this->endpoint;

        if ($this->method == 'post') {
            $requestObject = $this->post($requestUrl, $this->params);
        } else {
            $requestObject = $this->get($requestUrl, $this->params);
        }

        $response = $requestObject->getBody();
        $this->statusCode = $requestObject->getStatusCode();
        $this->response = $response->getContents();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->getStatusCode();
    }


}
