<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Response;


class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin'])->only(['store','destroy']);
        $this->middleware(['role:admin|moderator'])->only('update');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories= QueryBuilder::for(Category::class)
        ->allowedFields(['id','name'])
        ->allowedFilters(['name'])
        ->allowedSorts(['name'])
        ->paginate();

        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = Category::create([
            'name'=>$request->name
        ]);

        return (new CategoryResource($category))->response()
        ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category_f= QueryBuilder::for(Category::class)
        ->allowedFields('id','name','products.name')
        ->allowedIncludes(['products'])
        ->where('id',$category->id)
        ->first()
        ;
       return new CategoryResource($category_f);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->update([
            'name'=>$request->name
        ]);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }

}
