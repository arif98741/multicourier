<?php

namespace Xenon\MultiCourier;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
    private $method;
    private $params;

    /**
     * @param $base_url
     * @param $endpoint
     * @param $method
     * @param $params
     */
    public function __construct($base_url, $endpoint, $method, $params)
    {
        $this->base_url = $base_url;
        $this->endpoint = $endpoint;
        $this->method = $method;
        $this->params = $params;
    }

    /**
     * @param false $verify
     * @throws GuzzleException
     */
    private function get($requestUrl, array $query, bool $verify = false, $timeout = 10.0)
    {
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout' => $timeout,
        ]);

        return $client->request('GET', '', [
            'query' => $query,
            'verify' => $verify
        ]);

    }

    /**
     * @param false $verify
     * @throws GuzzleException
     */
    private function post($requestUrl, array $query, bool $verify = false, $timeout = 10.0)
    {
        $client = new Client([
            'base_uri' => $requestUrl,
            'timeout' => 10.0,
        ]);

        return $client->request('POST', '', [
            'query' => $query,
            'verify' => $verify,
            'headers' => [
                'API-KEY' => '0DPa',
                'API-SECRET' => 'XgxBg',
                'USER-ID' => 'K9367',
            ]
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function executeRequest()
    {
        if ($this->method == 'post') {
            $requestUrl = $this->base_url . $this->endpoint;

            $x = $this->post($requestUrl, $this->params);
            $response = $x->getBody();
        } else {
            $requestUrl = $this->base_url . $this->endpoint;

            $x = $this->get($requestUrl, $this->params);
            $response = $x->getBody();
        }

    }

}
