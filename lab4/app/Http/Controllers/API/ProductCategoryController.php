<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends BaseController
{
    public function index()
    {
        $categories = ProductCategory::all();
        return $this->sendResponse(ProductCategoryResource::collection($categories), 'success');
    }

    public function show($id)
    {
        $category = ProductCategory::find($id);
        if (is_null($category))
            return $this->sendError('Product category state does not exist.');
        return $this->sendResponse(new ProductCategoryResource($category), 'success');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:product_categories,name',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $category = ProductCategory::create($input);
        return $this->sendResponse(new ProductCategoryResource($category), 'The product category was created.');
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:product_categories,name',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $productCategory->update($input);
        return $this->sendResponse(new ProductCategoryResource($productCategory), 'The product category was updated.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return $this->sendResponse([], 'The product category was deleted');
    }
}
