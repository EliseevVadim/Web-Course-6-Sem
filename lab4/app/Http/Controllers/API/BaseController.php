<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="PizzGram Api Documentation",
 *      description="L5 Swagger PizzGram Api description",
 *      @OA\Contact(
 *          email="eliseevv02@mail.ru"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * @OA\SecurityScheme (
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer"
 *)
 * @OA\Server(
 *      url="http://localhost:8000/api",
 *      description="PizzGram API Server"
 * )
 * @OA\Tag(
 *     name="PizzGram API",
 *     description="API Endpoints of PizzGram"
 * )
 */
class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
