<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CheckoutResource;
use App\Models\Checkout;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends BaseController
{

    /**
     * @OA\Get (
     *     path="/checkouts",
     *     operationId="getAllCheckouts",
     *     summary="Get list of all checkouts",
     *     tags={"Checkouts"},
     *     description="Returns list of checkouts",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Response (
     *        response=200,
     *        description="success",
     *     ),
     *     @OA\Response (
     *        response=401,
     *        description="Unauthorised",
     *     ),
     *     @OA\Response (
     *         response=403,
     *         description="Forbidden"
     *     )
     *)
     */
    public function index()
    {
        $checkouts = Checkout::all();
        return $this->sendResponse(CheckoutResource::collection($checkouts), 'success');
    }

    /**
     * @OA\Get (
     *     path="/checkouts/{id}",
     *     operationId="getCheckoutById",
     *     summary="Get one checkout by id",
     *     tags={"Checkouts"},
     *     description="Returns object of checkout",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Checkout id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response (
     *        response=200,
     *        description="success",
     *        @OA\JsonContent (
     *           @OA\Property(property="checkout", type="object", ref="#/components/schemas/Checkout")
     *        )
     *     ),
     *     @OA\Response (
     *        response=401,
     *        description="Unauthorised",
     *     ),
     *     @OA\Response (
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response (
     *         response=404,
     *         description="Not found"
     *     )
     *)
     */
    public function show($id)
    {
        $checkout = Checkout::find($id);
        if (is_null($checkout))
            return $this->sendError('Checkout does not exist.');
        return $this->sendResponse(new CheckoutResource($checkout), 'success');
    }

    /**
     * @OA\Post (
     *     path="/checkouts",
     *     operationId="addCheckout",
     *     tags={"Checkouts"},
     *     summary="Add new checkout",
     *     description="Adds new checkout",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="cart_id",
     *          description="Id of cart",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="checkout_state_id",
     *          description="Id of checkout state",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="sum",
     *          description="Final checkout cost",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody (
     *        required=true,
     *        description="The adding request",
     *        @OA\JsonContent(
     *           @OA\Property(property="cart_id",type="integer",example="1"),
     *           @OA\Property(property="checkout_state_id",type="integer",example="1"),
     *           @OA\Property(property="sum",type="integer",example="1"),
     *        )
     *     ),
     *     @OA\Response (
     *        response=200,
     *        description="The checkout was created.",
     *        @OA\JsonContent (
     *           @OA\Property(property="checkout", type="object", ref="#/components/schemas/Checkout")
     *        )
     *     ),
     *     @OA\Response (
     *        response=401,
     *        description="Unauthorised",
     *     ),
     *      @OA\Response (
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response (
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *     )
     *)
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'cart_id' => 'required|integer',
                'checkout_state_id' => 'required|integer',
                'sum' => 'required|integer',
                'client_full_name' => 'required|string',
                'client_email' => 'required|email',
                'client_address' => 'required|string'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation failed.', $validator->errors(),422);
            }
            $checkout = Checkout::create($input);
            $ordersIds = Order::where('cart_id', $checkout->cart_id)->select('id')->get();
            Order::destroy($ordersIds);
            return $this->sendResponse(new CheckoutResource($checkout), 'The checkout was created.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Put(
     *      path="/checkouts/{id}",
     *      operationId="updateCheckout",
     *      tags={"Checkouts"},
     *      summary="Update existing checkout",
     *      description="Returns updated checkout data",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="cart_id",
     *          description="Id of cart",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="checkout_state_id",
     *          description="Id of checkout state",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="sum",
     *          description="Final checkout cost",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody (
     *        required=true,
     *        description="The updating request",
     *        @OA\JsonContent(
     *           @OA\Property(property="cart_id",type="integer",example="1"),
     *           @OA\Property(property="checkout_state_id",type="integer",example="1"),
     *           @OA\Property(property="sum",type="integer",example="1"),
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="The checkout was updated.",
     *          @OA\JsonContent(ref="#/components/schemas/Checkout")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     * )
     */
    public function update(Request $request, Checkout $checkout)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'cart_id' => 'required|integer',
                'checkout_state_id' => 'required|integer',
                'sum' => 'required|integer'
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors(), 'Validation failed.',422);
            }
            $checkout->update($input);
            return $this->sendResponse(new CheckoutResource($checkout), 'The checkout was updated.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Delete (
     *     path="/checkouts/{id}",
     *     operationId="deleteCheckout",
     *     tags={"Checkouts"},
     *     summary="Delete checkout by id",
     *     description="Deletes checkout by id",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Checkout id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response (
     *        response=200,
     *        description="The checkout was deleted.",
     *     ),
     *     @OA\Response (
     *        response=401,
     *        description="Unauthorised",
     *     ),
     *      @OA\Response (
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response (
     *         response=404,
     *         description="Not found"
     *     ),
     *     @OA\Response (
     *         response=400,
     *         description="Bad request"
     *     )
     *)
     */
    public function destroy(Checkout $checkout)
    {
        try {
            $checkout->delete();
            return $this->sendResponse([], 'The checkout was deleted.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }
}
