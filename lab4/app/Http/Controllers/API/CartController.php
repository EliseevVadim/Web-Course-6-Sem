<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends BaseController
{
    public function index()
    {
        $carts = Cart::all();
        return $this->sendResponse(CartResource::collection($carts), 'success');
    }

    public function show($id)
    {
        $cart = Cart::find($id);
        if (is_null($cart))
            return $this->sendError('Cart does not exist.');
        return $this->sendResponse(new CartResource($cart), 'success');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required|integer|unique:carts,user_id'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $cart = Cart::create($input);
        return $this->sendResponse(new CartResource($cart), 'The cart was created.');
    }

    public function update(Request $request, Cart $cart)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required|integer|unique:carts,user_id'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $cart->update($input);
        return $this->sendResponse(new CartResource($cart), 'The cart was updated.');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return $this->sendResponse([], 'The cart was deleted.');
    }
}
