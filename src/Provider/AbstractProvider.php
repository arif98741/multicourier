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

namespace Xenon\MultiCourier\Provider;


use Illuminate\Http\JsonResponse;

abstract class AbstractProvider implements ProviderRoadmap
{
    protected $senderObject;

    abstract public function sendRequest();

    /**
     * @param $result
     * @param $data
     * @return JsonResponse
     * @since v1.0.20
     * @version v1.0.20
     */
    public function generateReport($result, $data): JsonResponse
    {
        return response()->json([
            'status' => 'response',
            'response' => $result,
            'provider' => get_class($this),
            'send_time' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @return mixed
     */
    abstract public function errorException();

    /**
     * Return Report As Array
     */
    public function toArray(): array
    {
        return [

        ];
    }

    /**
     * Return Report As Json
     * @deprecated
     */
    public function toJson()
    {
        return json_encode();
    }
}
