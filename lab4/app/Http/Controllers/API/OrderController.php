<?php

namespace App\Http\Controllers\API;



use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController
{
    public function index()
    {
        $orders = Order::all();
        return $this->sendResponse(OrderResource::collection($orders), 'success');
    }

    public function show($id)
    {
        $order = Order::find($id);
        if (is_null($order))
            return $this->sendError('Order does not exist.');
        return $this->sendResponse(new OrderResource($order), 'success');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'sum' => 'required|integer',
            'cart_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $order = Order::create($input);
        return $this->sendResponse(new OrderResource($order), 'The order was created.');
    }

    public function update(Request $request, Order $order)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'sum' => 'required|integer',
            'cart_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $order->update($input);
        return $this->sendResponse(new OrderResource($order), 'The order was updated.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return $this->sendResponse([], 'The order was deleted.');
    }
}
