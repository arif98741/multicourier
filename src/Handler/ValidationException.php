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

namespace Xenon\MultiCourier\Handler;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ValidationException
 * @package Xenon\MultiCourierLog\Handler
 * @version v1.0.20
 * @since v1.0.20
 */
class ValidationException extends \Exception
{
    /**
     * Report the exception.
     *
     * @return void
     * @version v1.0.20
     * @since v1.0.20
     */
    public function report()
    {
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return Response
     * @version v1.0.20
     * @since v1.0.20
     */
    public function render(Request $request)
    {

    }
}
