<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products), 'success');
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product))
            return $this->sendError('Product does not exist.');
        return $this->sendResponse(new ProductResource($product), 'success');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:products,name',
            'description' => 'required',
            'image_path' => 'required',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'category_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $product = Product::create($input);
        return $this->sendResponse(new ProductResource($product), 'The product was created.');
    }

    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:products,name',
            'description' => 'required',
            'image_path' => 'required',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'category_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $product->update($input);
        return $this->sendResponse(new ProductResource($product), 'The product was updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse([], 'Product deleted.');
    }
}
