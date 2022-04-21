<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/posts",
     *     operationId="getAllPosts",
     *     summary="Get list of all posts",
     *     tags={"Posts"},
     *     description="Returns list of posts",
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
        $posts = Post::all();
        return $this->sendResponse(PostResource::collection($posts), 'success');
    }

    /**
     * @OA\Get (
     *     path="/posts/{id}",
     *     operationId="getPostById",
     *     summary="Get one post by id",
     *     tags={"Posts"},
     *     description="Returns object of post",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Post id",
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
     *           @OA\Property(property="post", type="object", ref="#/components/schemas/Post")
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
        $post = Post::find($id);
        if (is_null($post))
            return $this->sendError('Post does not exist.');
        return $this->sendResponse(new PostResource($post), 'success');
    }

    /**
     * @OA\Post (
     *     path="/posts",
     *     operationId="addPost",
     *     tags={"Posts"},
     *     summary="Add new post",
     *     description="Adds new post",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="title",
     *          description="Post title",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="description",
     *          description="Post content",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="image_path",
     *          description="Uploaded image path",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\RequestBody (
     *        required=true,
     *        description="The adding request",
     *        @OA\JsonContent(
     *           @OA\Property(property="title",type="string",example="Some post title"),
     *           @OA\Property(property="description",type="string",example="Some post content"),
     *           @OA\Property(property="image_path",type="string",example="Some post attachment path"),
     *        )
     *     ),
     *     @OA\Response (
     *        response=200,
     *        description="The post was created.",
     *        @OA\JsonContent (
     *           @OA\Property(property="post", type="object", ref="#/components/schemas/Post")
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
     *     )
     *)
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'image_path' => 'nullable',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input['posting_time'] = Carbon::now();
        $post = Post::create($input);
        return $this->sendResponse(new PostResource($post), 'The post was created.');
    }

    /**
     * @OA\Put(
     *      path="/posts/{id}",
     *      operationId="updatePost",
     *      tags={"Posts"},
     *      summary="Update existing post",
     *      description="Returns updated post data",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="title",
     *          description="Post title",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          description="Post content",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="image_path",
     *          description="Uploaded image path",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody (
     *        required=true,
     *        description="The updating request",
     *        @OA\JsonContent(
     *           @OA\Property(property="title",type="string",example="Some post title"),
     *           @OA\Property(property="description",type="string",example="Some post content"),
     *           @OA\Property(property="image_path",type="string",example="Some post attachment path"),
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="The post was updated.",
     *          @OA\JsonContent(ref="#/components/schemas/Post")
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
     *      )
     * )
     */
    public function update(Request $request, Post $post)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'nullable',
            'description' => 'nullable',
            'image_path' => 'nullable',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $post->update($input);
        return $this->sendResponse(new PostResource($post), 'The post was updated.');
    }

    /**
     * @OA\Delete (
     *     path="/posts/{id}",
     *     operationId="deletePost",
     *     tags={"Posts"},
     *     summary="Delete post by id",
     *     description="Deletes post by id",
     *     security={
     *         {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Post id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response (
     *        response=200,
     *        description="The post was deleted.",
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
     *     )
     *)
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}
