<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\QueryBuilder;

class ProductsController extends Controller
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
        //
        $products= QueryBuilder::for(Product::class)
        ->allowedFields(['id','name','media.id','media.file_name'])
        ->allowedFilters(['name'])
        ->allowedSorts(['name'])
        ->allowedIncludes(['media'])
        ->paginate();

        return new ProductCollection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::create([
            'name'=>$request->name
        ]);

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)->toMediaCollection();
            }
        }

        if($request->has('categories')){
            $product->categories()->sync($request->categories);
        }

        return (new ProductResource($product))->response()
        ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product_f= QueryBuilder::for(Product::class)
        ->allowedFields('id','name','media.id','media.file_name')
        ->allowedIncludes(['media'])
        ->where('id',$product->id)
        ->first()
        ;
       return new ProductResource($product_f);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update([
            'name'=>$request->name
        ]);

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)->toMediaCollection();
            }
        }

        if($request->has('categories')){
            $product->categories()->sync($request->categories);
        }

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }

}
