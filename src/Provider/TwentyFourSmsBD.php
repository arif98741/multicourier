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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Xenon\MultiCourier\Handler\ParameterException;
use Xenon\MultiCourier\Sender;

class TwentyFourSmsBD extends AbstractProvider
{
    /**
     * TwenforSmsBD constructor.
     * @param Sender $sender
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * Send Request To Api and Send Message
     * @throws GuzzleException
     */
    public function sendRequest()
    {
        $number = $this->senderObject->getMobile();
        $text = $this->senderObject->getMessage();
        $config = $this->senderObject->getConfig();

        $client = new Client([
            'base_uri' => 'https://24smsbd.com/api/bulkSmsApi',
            'timeout' => 10.0,
            'verify' => false,
        ]);


        $response = $client->request('POST', '', [
            'query' => [
                'apiKey' => $config['apiKey'],
                'sender_id' => $config['sender_id'],
                'mobileNo' => $number,
                'message' => $text,
            ]
        ]);

        $body = $response->getBody();
        $smsResult = $body->getContents();

        $data['number'] = $number;
        $data['message'] = $text;
        $report = $this->generateReport($smsResult, $data);
        return $report->getContent();
    }

    /**
     * @throws ParameterException
     */
    public function errorException()
    {
        if (!array_key_exists('apiKey', $this->senderObject->getConfig())) {
            throw new ParameterException('apiKey key is absent in configuration');
        }

        if (!array_key_exists('sender_id', $this->senderObject->getConfig())) {
            throw new ParameterException('sender_id key is absent in configuration');
        }

    }
}
