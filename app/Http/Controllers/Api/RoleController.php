<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleTransformer;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $role_repo; 

    public function __construct()
    {
        $this->role_repo = app(RoleRepository::class);
    }

    public function index(Request $request)
    {
        $roles = $this->role_repo->listRole($request);

        return RoleTransformer::collection($roles);
    }
}
