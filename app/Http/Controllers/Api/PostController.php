<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{

    use ApiResponse;

    public function index()
    {
        $posts = PostResource::collection(Post::paginate($this->paginateNumber));
        return $this->apiResponse($posts, 'success');
    }

    public function show(Post $post)
    {
        if ($post) {
            return $this->returnSuccess(new PostResource($post));
        } else {
            return $this->notFoundResponse();
        }
    }

    public function store(Request $request)
    {

        $validation = $this->validation($request);

        if ($validation instanceof Response) {
            return $validation;
        }

        $post = Post::create($request->all());
        if ($post) {
            return $this->createSuccess(new PostResource($post));
        } else {
            return $this->unKnownError();
        }
    }

    public function update(Request $request, Post $post)
    {
        $validation = $this->validation($request);

        if ($validation instanceof Response) {
            return $validation;
        }

        if (!$post) {
            return $this->notFoundResponse();
        }

        $post->update($request->all());
        if ($post) {
            return $this->returnSuccess(new PostResource($post));
        } else {
            return $this->unKnownError();
        }
    }

    public function destroy(Request $request, Post $post)
    {
        if ($post) {
            $post->delete();
            return $this->deleteSuccess();
        } else {
            return $this->unKnownError();
        }
    }

    public function validation($request)
    {
        $array = [
            'title' => 'required',
            'body' => 'required',
        ];

        return $this->apiValidation($request, $array);
    }
}
