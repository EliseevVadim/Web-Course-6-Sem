<?php

namespace App\Http\Controllers\API;



use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/orders",
     *     operationId="getAllOrders",
     *     summary="Get list of all orders",
     *     tags={"Orders"},
     *     description="Returns list of orders",
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
        $orders = Order::all();
        return $this->sendResponse(OrderResource::collection($orders), 'success');
    }

    /**
     * @OA\Get (
     *     path="/orders/{id}",
     *     operationId="getOrderById",
     *     summary="Get one order by id",
     *     tags={"Orders"},
     *     description="Returns object of order",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Order id",
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
     *           @OA\Property(property="order", type="object", ref="#/components/schemas/Order")
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
        $order = Order::find($id);
        if (is_null($order))
            return $this->sendError('Order does not exist.');
        return $this->sendResponse(new OrderResource($order), 'success');
    }

    /**
     * @OA\Post (
     *     path="/orders",
     *     operationId="addOrder",
     *     tags={"Orders"},
     *     summary="Add new order",
     *     description="Adds new order",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="product_id",
     *          description="Ordered product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="quantity",
     *          description="Quantity of ordered product units",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="sum",
     *          description="Sum of the order",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="cart_id",
     *          description="Id of cart, where order puts in",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\RequestBody (
     *        required=true,
     *        description="The adding request",
     *        @OA\JsonContent(
     *           @OA\Property(property="product_id",type="integer",example="1"),
     *           @OA\Property(property="quantity",type="integer",example="1"),
     *           @OA\Property(property="sum",type="integer",example="1"),
     *           @OA\Property(property="cart_id",type="integer",example="1")
     *        )
     *     ),
     *     @OA\Response (
     *        response=200,
     *        description="The order was created.",
     *        @OA\JsonContent (
     *           @OA\Property(property="order", type="object", ref="#/components/schemas/Order")
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
                'product_id' => 'required|integer',
                'quantity' => 'required|integer',
                'sum' => 'required|integer',
                'cart_id' => 'required|integer'
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors(), 'Validation failed.',422);
            }
            $product = Product::find($input['product_id']);
            $product->orders_count += $input['quantity'];
            $product->save();
            $order = Order::create($input);
            return $this->sendResponse(new OrderResource($order), 'The order was created.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Put(
     *      path="/orders/{id}",
     *      operationId="updateOrder",
     *      tags={"Orders"},
     *      summary="Update existing order",
     *      description="Returns updated order data",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Order id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="product_id",
     *          description="Ordered product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="quantity",
     *          description="Quantity of ordered product units",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="sum",
     *          description="Sum of the order",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="cart_id",
     *          description="Id of cart, where order puts in",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody (
     *        required=true,
     *        description="The updating request",
     *        @OA\JsonContent (
     *           @OA\Property(property="product_id",type="integer",example="1"),
     *           @OA\Property(property="quantity",type="integer",example="1"),
     *           @OA\Property(property="sum",type="integer",example="1"),
     *           @OA\Property(property="cart_id",type="integer",example="1")
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="The order was updated.",
     *          @OA\JsonContent(ref="#/components/schemas/Order")
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
    public function update(Request $request, Order $order)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'product_id' => 'required|integer',
                'quantity' => 'required|integer',
                'sum' => 'required|integer',
                'cart_id' => 'required|integer'
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors(), 'Validation failed.',422);
            }
            $order->update($input);
            return $this->sendResponse(new OrderResource($order), 'The order was updated.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Delete (
     *     path="/orders/{id}",
     *     operationId="deleteOrder",
     *     tags={"Orders"},
     *     summary="Delete order by id",
     *     description="Deletes order by id",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Order id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response (
     *        response=200,
     *        description="The order was deleted.",
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
    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return $this->sendResponse([], 'The order was deleted.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }
}
