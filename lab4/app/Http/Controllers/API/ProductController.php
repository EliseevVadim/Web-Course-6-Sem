<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/products",
     *     operationId="getAllProducts",
     *     summary="Get list of all products",
     *     tags={"Products"},
     *     description="Returns list of products",
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
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products), 'success');
    }

    /**
     * @OA\Get (
     *     path="/products/{id}",
     *     operationId="getProductById",
     *     summary="Get one product by id",
     *     tags={"Products"},
     *     description="Returns object of product",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Product id",
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
     *           @OA\Property(property="product", type="object", ref="#/components/schemas/Product")
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
        $product = Product::find($id);
        if (is_null($product))
            return $this->sendError('Product does not exist.');
        return $this->sendResponse(new ProductResource($product), 'success');
    }

    /**
     * @OA\Post (
     *     path="/products",
     *     operationId="addProduct",
     *     tags={"Products"},
     *     summary="Add new product",
     *     description="Adds new product",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="name",
     *          description="Product name",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="description",
     *          description="Product description",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="image_path",
     *          description="Uploaded image path",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="weight",
     *          description="Product weight",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="price",
     *          description="Product price",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="category_id",
     *          description="Product category id",
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
     *           @OA\Property(property="name",type="string",example="Some product name"),
     *           @OA\Property(property="description",type="string",example="Some product description"),
     *           @OA\Property(property="image_path",type="string",example="Some product image path"),
     *           @OA\Property(property="weight",type="string",example="100"),
     *           @OA\Property(property="price",type="string",example="300"),
     *           @OA\Property(property="category_id",type="string",example="1"),
     *        )
     *     ),
     *     @OA\Response (
     *        response=200,
     *        description="The product was created.",
     *        @OA\JsonContent (
     *           @OA\Property(property="product", type="object", ref="#/components/schemas/Product")
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
                'name' => 'required|unique:products,name',
                'description' => 'required',
                'image_path' => 'required',
                'price' => 'required|integer',
                'weight' => 'required|integer',
                'category_id' => 'required|integer'
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors(), 'Validation failed.',422);
            }
            $product = Product::create($input);
            return $this->sendResponse(new ProductResource($product), 'The product was created.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Put(
     *      path="/products/{id}",
     *      operationId="updateProduct",
     *      tags={"Products"},
     *      summary="Update existing product",
     *      description="Returns updated product data",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="name",
     *          description="Product name",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="description",
     *          description="Product description",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="image_path",
     *          description="Uploaded image path",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="weight",
     *          description="Product weight",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="price",
     *          description="Product price",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="category_id",
     *          description="Product category id",
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
     *           @OA\Property(property="name",type="string",example="Some product name"),
     *           @OA\Property(property="description",type="string",example="Some product description"),
     *           @OA\Property(property="image_path",type="string",example="Some product image path"),
     *           @OA\Property(property="weight",type="string",example="100"),
     *           @OA\Property(property="price",type="string",example="300"),
     *           @OA\Property(property="category_id",type="string",example="1"),
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="The product was updated.",
     *          @OA\JsonContent(ref="#/components/schemas/Product")
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
    public function update(Request $request, Product $product)
    {
        try {
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
                return $this->sendError($validator->errors(), 'Validation failed.',422);
            }
            $product->update($input);
            return $this->sendResponse(new ProductResource($product), 'The product was updated.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Delete (
     *     path="/products/{id}",
     *     operationId="deleteProduct",
     *     tags={"Products"},
     *     summary="Delete product by id",
     *     description="Deletes product by id",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response (
     *        response=200,
     *        description="The product was deleted.",
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
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return $this->sendResponse([], 'Product deleted.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }
}
