<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This file is part of ProductManagement,
 * a BaseController management solution for Laravel
 * and should be parent class for other API controllers
 * Class AppBaseController
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class AppBaseController extends Controller
{
  /**
   * Send a Json Response
   *
   * @param String $result
   * @param String $message
   *
   * @return response
   */
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    /**
     * Send a Json Error
     *
     * @param String $error
     * @param int $code
     *
     * @return response
     */
    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }
}
