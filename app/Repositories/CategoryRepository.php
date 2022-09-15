<?php 

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

interface CategoryRepository {
    
    public function listCategories(Request $request);

}