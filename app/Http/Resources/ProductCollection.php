<?php

namespace App\Http\Resources;

use App\Domain\Products\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    protected $category;

    public function __construct(Category $category, $products)
    {
        parent::__construct($products);
        $this->category = $category;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'description' => $this->category->description,
                'products' => ProductResource::collection($this->collection)
            ],
        ];
    }
}
