<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CheckoutStateResource;
use App\Models\CheckoutState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutStateController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/checkout-states",
     *     operationId="getAllCheckoutStates",
     *     summary="Get list of all checkout states",
     *     tags={"Checkout states"},
     *     description="Returns list of checkout states",
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
        $states = CheckoutState::all();
        return $this->sendResponse(CheckoutStateResource::collection($states), 'success');
    }

    /**
     * @OA\Get (
     *     path="/checkout-states/{id}",
     *     operationId="getCheckoutStateById",
     *     summary="Get one checkout state by id",
     *     tags={"Checkout states"},
     *     description="Returns object of checkout state",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Checkout state id",
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
     *           @OA\Property(property="checkout-state", type="object", ref="#/components/schemas/CheckoutState")
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
        $state = CheckoutState::find($id);
        if (is_null($state))
            return $this->sendError('Checkout state does not exist.');
        return $this->sendResponse(new CheckoutStateResource($state), 'success');
    }

    /**
     * @OA\Post (
     *     path="/checkout-states",
     *     operationId="addCheckoutState",
     *     tags={"Checkout states"},
     *     summary="Add new checkout state",
     *     description="Adds new checkout state",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="name",
     *          description="Checkout state name",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\RequestBody (
     *        required=true,
     *        description="The adding request",
     *        @OA\JsonContent(
     *           @OA\Property(property="name",type="string",example="Some checkout state"),
     *        )
     *     ),
     *     @OA\Response (
     *        response=200,
     *        description="The checkout state was created.",
     *        @OA\JsonContent (
     *           @OA\Property(property="checkout-state", type="object", ref="#/components/schemas/CheckoutState")
     *        )
     *     ),
     *     @OA\Response (
     *        response=401,
     *        description="Unauthorised",
     *     ),
     *      @OA\Response (
     *         response=403,
     *         description="Forbidden"
     *     )
     *)
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:checkout_states,name',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $state = CheckoutState::create($input);
        return $this->sendResponse(new CheckoutStateResource($state), 'The post was created.');
    }

    /**
     * @OA\Put(
     *      path="/checkout-states/{id}",
     *      operationId="updateCheckoutState",
     *      tags={"Checkout states"},
     *      summary="Update existing checkout state",
     *      description="Returns updated checkout state data",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Checkout state id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Checkout state name",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody (
     *        required=true,
     *        description="The updating request",
     *        @OA\JsonContent(
     *           @OA\Property(property="name",type="string",example="Some checkout state"),
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="The checkout state was updated.",
     *          @OA\JsonContent(ref="#/components/schemas/CheckoutState")
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
     *      )
     * )
     */
    public function update(Request $request, CheckoutState $checkoutState)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:checkout_states,name'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $checkoutState->update($input);
        return $this->sendResponse(new CheckoutStateResource($checkoutState), 'The checkout state was updated.');
    }

    /**
     * @OA\Delete (
     *     path="/checkout-states/{id}",
     *     operationId="deleteCheckoutState",
     *     tags={"Checkout states"},
     *     summary="Delete checkout state by id",
     *     description="Deletes checkout state by id",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Checkout state id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response (
     *        response=200,
     *        description="The checkout state was deleted.",
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
     *     )
     *)
     */
    public function destroy(CheckoutState $checkoutState)
    {
        $checkoutState->delete();
        return $this->sendResponse([], 'The checkout state was deleted');
    }
}
