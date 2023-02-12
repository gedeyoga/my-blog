<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryTransformer;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories_repo = app(CategoryRepository::class);
        $categories=  $categories_repo->listCategories($request);

        return CategoryTransformer::collection($categories);
    }

    public function publicList(Request $request)
    {
        $categories_repo = app(CategoryRepository::class);
        $categories=  $categories_repo->listCategories($request);

        return CategoryTransformer::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories_repo = app(CategoryRepository::class);
        $category = $categories_repo->create($request->all());

        return response()->json([
            'message' => 'Berhasil menambahkan kategori',
            'data' => new CategoryTransformer($category)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( Category $category)
    {
        return new CategoryTransformer($category);
    }

    public function showByName( Request $request)
    {
        $category= Category::whereRaw('lower(name) = "' . strtolower($request->get('category')). '"')->first();
        return new CategoryTransformer($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $categories_repo = app(CategoryRepository::class);
        $category = $categories_repo->update( $category , $request->all());

        return response()->json([
            'message' => 'Berhasil mengubah kategori',
            'data' => new CategoryTransformer($category)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Berhasil menghapus kategori'
        ]);
    }
}
