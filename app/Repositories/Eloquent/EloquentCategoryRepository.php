<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{

    public function listCategories(Request $request)
    {
        $users = $this->model;

        if($request->get('search')) {
            $users = $users->where(function($query) use ($request) {
                $query->where('name' , 'like' , '%'.$request->get('search').'%');
            });
        }

        return $users->paginate($request->get('per_page' , 10));
    }
    
}
