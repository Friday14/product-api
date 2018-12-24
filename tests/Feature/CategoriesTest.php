<?php

namespace Tests\Feature;

use App\Domain\Products\Category;

class CategoriesTest extends BaseFeature
{
    public function testGetCategories()
    {
        $this->createCategories();
        $response = $this->get('/api/categories');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'name',
                    'description'
                ]
            ]
        ]);
    }

    public function testGetCategory()
    {
        $this->createCategories();
        $response = $this->get(route('categories.show', Category::first()));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'products' => [
                    [
                        'name',
                        'description',
                        'price',
                        'created_at'
                    ]
                ]
            ]
        ]);
    }

    public function testCreateCategory()
    {
        $payload = [
          'name' => 'New Category',
          'description' => 'Sup sup'
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getUserToken())
            ->post(route('categories.store'), $payload);

        $response->assertStatus(200);
    }

    public function testUpdateCategory()
    {
        $this->createCategories();
        $category = Category::first();
        $payload = ['name' => 'new name', 'description' => 'new description'];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getUserToken())
            ->put(route('categories.update', $category), $payload);

        $response->assertStatus(200);

        $updatedCategory = Category::find($category->id);

        $this->assertNotEquals($category->name, $updatedCategory->name);
        $this->assertNotEquals($category->description, $updatedCategory->description);

        $this->assertEquals($updatedCategory->name, $payload['name']);
        $this->assertEquals($updatedCategory->description, $payload['description']);

    }

    public function testDestroyCategory()
    {
        $this->createCategories();
        $category = Category::first();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getUserToken())
            ->delete(route('categories.destroy', $category));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
    }
}
