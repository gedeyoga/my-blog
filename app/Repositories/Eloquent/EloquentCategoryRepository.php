<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{

    public function listCategories(Request $request)
    {
        $categories = $this->model
        
        ->when($request->get('search'), function ($query) use ($request) {
            return $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%');
            });
        })
        
        ->when($request->get('category') , function($query) use ($request) {
            return $query->where('name' ,'like' , '%'. $request->get('category').'%');
        });


        if(!is_null($request->get('paginate'))) {
            return $categories->get();
        }

        return $categories->paginate($request->get('per_page' , 10));
    }
    
}
