<?php

namespace App\Repositories\Eloquent;

use App\Events\PostIsCreated;
use App\Events\PostIsUpdated;
use App\Events\PostWasPublished;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

class EloquentPostRepository extends EloquentBaseRepository implements PostRepository
{

    public function createPost(array $data)
    {
        $post = $this->model->create($data);
        
        if(isset($data['category_id'])) {
            $post = $this->assignCategory($post , $data['category_id']);
        }

        event(new PostIsCreated($post));


        return $post;
    }

    public function updatePost(Post $post, array $data)
    {
        $post->fill($data);
        $post->save();

        if (isset($data['category_id'])) {

            $post = $this->assignCategory($post , $data['category_id']);

        }

        event(new PostIsUpdated($post));


        return $post;
    }

    public function deletePost(Post $post)
    {
        $post->delete();

        return $post;
    }

    public function listPosts(Request $request , $status = null)
    {
        $posts = $this->model;

        if($request->get('with')) {
            $relations = explode(',' , $request->get('with'));
            $posts->with($relations);
        }

        if ($request->get('search')) {
            $posts = $posts
                ->where(function ($query) use ($request) {
                    $query
                        ->where('title', 'like', '%' . $request->get('search') . '%');
                });
        }

        if($request->get('category')) {
             $posts = $posts
                ->whereHas('category' , function($query) use ($request) {
                    $query->where('name' , $request->get('category'));
                });
        }else if($request->get('category_exclude')) {
            $category_exclude = explode(',' , $request->get('category_exclude'));
            $posts = $posts->whereHas('category' , fn($query) => $query->whereNotIn('name' , $category_exclude));
        }

        $posts = $posts->when($request->get('category_id') , function($query) use ($request) {
            return  $query->whereHas('category' , fn($query) => $query->whereIn('id' , $request->get('category_id')));
        });

        if (!is_null($status)) {
             $posts = $posts->where('status', $status);
        }else if($request->get('status')) {
             $posts = $posts->where('status' , $request->get('status'));
        } 

        if(!is_null($request->get('limit'))) {
            return $posts->limit($request->get('limit'))->get();
        }

        return $posts->paginate($request->get('per_page' , 10));
    }

    public function assignCategory(Post $post , array $category_ids)
    {
        $post->post_category()->delete();

        foreach ($category_ids as $category_id) {

            $post->category()->attach($category_id);
        }

        return $post;
    }

    public function statusChange( Post $post , $data)
    {
        $post = $this->update($post , $data);

        if($post->status == 'publish') {
            event(new PostWasPublished($post));
        }
        
        return $post;
    }
    
}
