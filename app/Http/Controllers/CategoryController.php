<?php

namespace App\Http\Controllers;

use App\Domain\Products\Category;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        return new CategoryCollection(Category::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();

        return response()->json(['message' => 'Category created', 'data' => new CategoryResource($category)]);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return ProductCollection
     */
    public function show(Category $category)
    {
        $products = $category->products()->paginate(5);

        return new ProductCollection($category, $products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        try {
            $category->name = $request->input('name', $category->name);
            $category->description = $request->input('description', $category->description);
            $category->save();

            return response()->json(['message' => 'Category updated', 'data' => new CategoryResource($category)]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return response()->json(['message' => 'Category deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'You do not have access'], 400);
        }
    }
}
