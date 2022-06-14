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

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Storage;
use Xenon\MultiCourier\Courier;
use Xenon\MultiCourier\Handler\ErrorException;
use Xenon\MultiCourier\Handler\ParameterException;
use Xenon\MultiCourier\Handler\RequestException;
use Xenon\MultiCourier\Request;

class Pathao extends AbstractProvider
{
    /**
     * @var string
     */
    private $base_url = 'http://hermes-api.p-stageenv.xyz/aladdin/api/v1/';
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
            $this->setBaseUrl('https://api-hermes.pathaointernal.com/aladdin/api/v1/');
        }
    }

    /**
     * Send Request To Api and Send Message
     * @throws GuzzleException
     * @throws RequestException
     * @throws ErrorException
     * @throws Exception
     */
    public function sendRequest()
    {
        $endpoint = $this->senderObject->getRequestEndpoint();
        $config = $this->senderObject->getConfig();
        $courierConfig = config('courier');
        if ($courierConfig == null) {
            throw new ErrorException("No multicourier.php file exist inside config directory. You should publish vendor Xenon\MultiCourier\MultiCourierServiceProvider");
        }

        $existance = Storage::disk('local')->exists('pathao_bearer_token.json');
        $headers = [];

        if ($existance) {
            $bearerToken = Storage::get('pathao_bearer_token.json');
            $bearerToken = json_decode($bearerToken);
            $bearerToken = $bearerToken[0];
            $headers = [
                'Authorization' => $bearerToken
            ];

            try {
                $client = new Client();
                $client->get(
                    $this->base_url . 'cities/1/zone-list',
                    array(
                        'verify' => false,
                        'headers' => $headers
                    ),
                );
            } catch (ClientException $e) {

                if ($e->getCode() == 401) {

                    $this->generateToken();
                    $bearerToken = Storage::get('pathao_bearer_token.json');
                    $bearerToken = json_decode($bearerToken);
                    $bearerToken = $bearerToken[0];
                    $headers = [
                        'Authorization' => $bearerToken
                    ];
                } else {
                    throw new RequestException($e->getMessage());
                }
            }
        } else {
            $this->generateToken();
            $bearerToken = Storage::get('pathao_bearer_token.json');
            $bearerToken = json_decode($bearerToken);
            $bearerToken = $bearerToken[0];
            $headers = [
                'Authorization' => $bearerToken
            ];
        }


        $requestMethod = $this->senderObject->getMethod();
        $request = new Request($this->getBaseUrl(), $endpoint, $requestMethod, $headers, $this->senderObject->getParams());
        $response = $request->executeRequest();

        return $response->getData();
    }

    /**
     * @return void
     * @throws RequestException
     * @throws Exception
     */
    private function generateToken(): void
    {
        $accessToken = $this->authorize();
        $accessTokenArray = ['Bearer' . ' ' . $accessToken];
        $accessTokenJson = json_encode($accessTokenArray);
        try {
            Storage::disk('local')->put('pathao_bearer_token.json', $accessTokenJson);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return Request
     * @throws RequestException
     */
    public function authorize()
    {
        $providerConfiguration = config('courier')['providers'][get_class($this)];
        $params = [
            'client_id' => $providerConfiguration['PATHAO_CLIENT_ID'],
            'client_secret' => $providerConfiguration['PATHAO_CLIENT_SECRET'],
            'username' => $providerConfiguration['PATHAO_USERNAME'],
            'password' => $providerConfiguration['PATHAO_PASSWORD'],
            'grant_type' => $providerConfiguration['PATHAO_GRANT_TYPE'],
        ];

        $request = new Request($this->getBaseUrl(), 'issue-token', 'post', [], $params);
        try {
            $response = $request->executeRequest();

            if ($response->statusCode == 200) {
                $jsonResponse = $response->response;
                $jsonDecode = json_decode($jsonResponse);
                return $jsonDecode->access_token;
            } else {
                throw new RequestException("Failed to authenticate pathao endpoint; Status Code " . $response->statusCode . ' ' . __CLASS__);

            }
        } catch (GuzzleException|RequestException $e) {
            throw new RequestException($e->getMessage());
        }

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

    /**
     * @return void
     */
    function placeOrder()
    {

        // TODO: Implement placeOrder() method.
    }

    /**
     * @return void
     */
    function getOrders()
    {
        // TODO: Implement getOrders() method.
    }
}
