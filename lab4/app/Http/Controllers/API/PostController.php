<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    public function index()
    {
        $posts = Post::all();
        return $this->sendResponse(PostResource::collection($posts), 'success');
    }

    public function show($id)
    {
        $post = Post::find($id);
        if (is_null($post))
            return $this->sendError('Post does not exist.');
        return $this->sendResponse(new PostResource($post), 'success');
    }

    public function store(Request $request)
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
        $input['posting_time'] = Carbon::now();
        $post = Post::create($input);
        return $this->sendResponse(new PostResource($post), 'The post was created.');
    }

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
        $post->title = $input['title'];
        $post->description = $input['description'];
        $post->image_path = $input['image_path'];
        $post->save();
        return $this->sendResponse(new PostResource($post), 'The post was updated.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}
