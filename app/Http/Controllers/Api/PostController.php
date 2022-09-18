<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostTransformer;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $post_repo = app(PostRepository::class);

        $posts = $post_repo->listPosts($request);

        return PostTransformer::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post_repo = app(PostRepository::class);

        $data = $request->except('thumbnail');

        $post = $post_repo->createPost($data);

        return response()->json([
            'message' => 'Berhasil memperbaharui postingan!',
            'data' => new PostTransformer($post)
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostTransformer($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post_repo = app(PostRepository::class);

        $data = $request->except('thumbnail');

        $post = $post_repo->updatePost($post , $data);

        return response()->json([
            'message' => 'Berhasil menambahkan postingan!',
            'data' => new PostTransformer($post)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post_repo = app(PostRepository::class);

        $post_repo->deletePost($post);

        return response()->json([
            'message' => 'Berhasil menghapus postingan!'
        ]);
    }
}
