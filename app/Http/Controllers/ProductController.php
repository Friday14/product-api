<?php

namespace App\Http\Controllers;

use App\Domain\Products\Product;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        if ($request->has('category_id')) {
            $product->categories()->attach($request->input('category_id'));
        }
        $product->save();

        return response()->json(['message' => 'Product created', 'data' => new ProductResource($product)]);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->name = $request->input('name', $product->name);
        $product->price = $request->input('price', $product->price);
        $product->description = $request->input('description', $product->description);
        if ($request->has('category_id')) {
            $product->categories()->attach($request->input('category_id'));
        }
        $product->save();

        return response()->json(['message' => 'Product updated', 'data' => new ProductResource($product)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return response()->json(['message' => 'Product deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'You do not have access'], 400);
        }
    }
}
