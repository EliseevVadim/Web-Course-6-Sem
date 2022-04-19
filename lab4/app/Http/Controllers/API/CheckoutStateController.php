<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CheckoutStateResource;
use App\Models\CheckoutState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutStateController extends BaseController
{
    public function index()
    {
        $states = CheckoutState::all();
        return $this->sendResponse(CheckoutStateResource::collection($states), 'success');
    }

    public function show($id)
    {
        $state = CheckoutState::find($id);
        if (is_null($state))
            return $this->sendError('Checkout state does not exist.');
        return $this->sendResponse(new CheckoutStateResource($state), 'success');
    }

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

    public function destroy(CheckoutState $checkoutState)
    {
        $checkoutState->delete();
        return $this->sendResponse([], 'The checkout state was deleted');
    }
}
