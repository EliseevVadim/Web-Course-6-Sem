<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class CartController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/carts",
     *     operationId="getAllCarts",
     *     summary="Get list of all carts",
     *     tags={"Carts"},
     *     description="Returns list of carts",
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
        $carts = Cart::all();
        return $this->sendResponse(CartResource::collection($carts), 'success');
    }

    /**
     * @OA\Get (
     *     path="/carts/{id}",
     *     operationId="getCartById",
     *     summary="Get one cart by id",
     *     tags={"Carts"},
     *     description="Returns object of cart",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Cart id",
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
     *           @OA\Property(property="cart", type="object", ref="#/components/schemas/Cart")
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
     *         description="Cart does not exist."
     *     )
     *)
     */
    public function show($id)
    {
        $cart = Cart::find($id);
        if (is_null($cart))
            return $this->sendError('Cart does not exist.');
        return $this->sendResponse(new CartResource($cart), 'success');
    }

    /**
     * @OA\Post (
     *     path="/carts",
     *     operationId="addCart",
     *     tags={"Carts"},
     *     summary="Add new cart",
     *     description="Adds new cart",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="user_id",
     *          description="Owners id",
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
     *           @OA\Property(property="user_id",type="integer",example="1"),
     *        )
     *     ),
     *     @OA\Response (
     *        response=200,
     *        description="The cart was created.",
     *        @OA\JsonContent (
     *           @OA\Property(property="product_category", type="object", ref="#/components/schemas/Cart")
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
     *     @OA\Response (
     *         response=422,
     *         description="Validation failed"
     *     )
     *)
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'user_id' => 'required|integer|unique:carts,user_id'
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors(), 'Validation failed.',422);
            }
            $cart = Cart::create($input);
            return $this->sendResponse(new CartResource($cart), 'The cart was created.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Put(
     *      path="/carts/{id}",
     *      operationId="updateCart",
     *      tags={"Carts"},
     *      summary="Update existing cart",
     *      description="Returns updated cart data",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Cart id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="user_id",
     *          description="New owners id",
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
     *           @OA\Property(property="user_id",type="integer",example="316"),
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="The cart was updated.",
     *          @OA\JsonContent(ref="#/components/schemas/Cart")
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
     *      @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     * )
     */
    public function update(Request $request, Cart $cart)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'user_id' => 'required|integer|unique:carts,user_id'
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors(), 'Validation failed.',422);
            }
            $cart->update($input);
            return $this->sendResponse(new CartResource($cart), 'The cart was updated.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Delete (
     *     path="/carts/{id}",
     *     operationId="deleteCart",
     *     tags={"Carts"},
     *     summary="Delete cart by id",
     *     description="Deletes cart by id",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Cart id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response (
     *        response=200,
     *        description="The cart was deleted.",
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
     *     )
     *)
     */
    public function destroy(Cart $cart)
    {
        try {
            $cart->delete();
            return $this->sendResponse([], 'The cart was deleted.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }
}
