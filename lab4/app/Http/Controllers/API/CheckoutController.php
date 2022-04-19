<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CheckoutResource;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends BaseController
{
    public function index()
    {
        $checkouts = Checkout::all();
        return $this->sendResponse(CheckoutResource::collection($checkouts), 'success');
    }

    public function show($id)
    {
        $checkout = Checkout::find($id);
        if (is_null($checkout))
            return $this->sendError('Checkout does not exist.');
        return $this->sendResponse(new CheckoutResource($checkout), 'success');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'cart_id' => 'required|integer',
            'checkout_state_id' => 'required|integer',
            'sum' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $checkout = Checkout::create($input);
        return $this->sendResponse(new CheckoutResource($checkout), 'The checkout was created.');
    }

    public function update(Request $request, Checkout $checkout)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'cart_id' => 'required|integer',
            'checkout_state_id' => 'required|integer',
            'sum' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $checkout->update($input);
        return $this->sendResponse(new CheckoutResource($checkout), 'The checkout was updated.');
    }

    public function destroy(Checkout $checkout)
    {
        $checkout->delete();
        return $this->sendResponse([], 'The checkout was deleted.');
    }
}
