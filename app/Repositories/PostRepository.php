<?php 

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

interface PostRepository {
    public function createPost(array $data);
    
    public function updatePost(Post $post, array $data);

    public function deletePost(Post $post);

    public function listPosts(Request $request);
    
}