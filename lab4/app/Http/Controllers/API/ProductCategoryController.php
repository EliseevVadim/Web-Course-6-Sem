<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/product_categories",
     *     operationId="getAllProductCategories",
     *     summary="Get list of all product categories",
     *     tags={"Product categories"},
     *     description="Returns list of product categories",
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
        $categories = ProductCategory::all();
        return $this->sendResponse(ProductCategoryResource::collection($categories), 'success');
    }

    /**
     * @OA\Get (
     *     path="/product_categories/{id}",
     *     operationId="getProductCategoryById",
     *     summary="Get one product category by id",
     *     tags={"Product categories"},
     *     description="Returns object of product category",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Product category id",
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
     *           @OA\Property(property="product_category", type="object", ref="#/components/schemas/ProductCategory")
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
        $category = ProductCategory::find($id);
        if (is_null($category))
            return $this->sendError('Product category state does not exist.');
        return $this->sendResponse(new ProductCategoryResource($category), 'success');
    }

    /**
     * @OA\Post (
     *     path="/product_categories",
     *     operationId="addProductCategory",
     *     tags={"Product categories"},
     *     summary="Add new product category",
     *     description="Adds new product category",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="name",
     *          description="Product category name",
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
     *           @OA\Property(property="name",type="string",example="Some Product Categoty"),
     *        )
     *     ),
     *     @OA\Response (
     *        response=200,
     *        description="The product category was created.",
     *        @OA\JsonContent (
     *           @OA\Property(property="product_category", type="object", ref="#/components/schemas/ProductCategory")
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
     *     @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *     )
     *)
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|unique:product_categories,name',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors(), 'Validation failed.',422);
            }
            $category = ProductCategory::create($input);
            return $this->sendResponse(new ProductCategoryResource($category), 'The product category was created.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Put(
     *      path="/product_categories/{id}",
     *      operationId="updateProductCategory",
     *      tags={"Product categories"},
     *      summary="Update existing prodcut category",
     *      description="Returns updated prodcut category data",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Product category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Product category name",
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
     *           @OA\Property(property="name",type="string",example="Some Product Categoty"),
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="The product category was updated.",
     *          @OA\JsonContent(ref="#/components/schemas/ProductCategory")
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
    public function update(Request $request, ProductCategory $productCategory)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|unique:product_categories,name',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors(), 'Validation failed.',422);
            }
            $productCategory->update($input);
            return $this->sendResponse(new ProductCategoryResource($productCategory), 'The product category was updated.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }
    /**
     * @OA\Delete (
     *     path="/product_categories/{id}",
     *     operationId="deleteProductCategory",
     *     tags={"Product categories"},
     *     summary="Delete product category by id",
     *     description="Deletes product category by id",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Product category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response (
     *        response=200,
     *        description="The product category was deleted.",
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
    public function destroy(ProductCategory $productCategory)
    {
        try {
            $productCategory->delete();
            return $this->sendResponse([], 'The product category was deleted.');
        }
        catch (\Exception $exception) {
            return $this->sendError(['error' => $exception->getMessage()], $exception->getMessage(), 400);
        }
    }
}
