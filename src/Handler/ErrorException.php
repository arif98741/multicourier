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

class ErrorException extends \Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return Response
     */
    public function render(Request $request)
    {

    }
}
