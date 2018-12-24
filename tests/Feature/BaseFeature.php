<?php

namespace Tests\Feature;

use App\Domain\Products\Category;
use App\Domain\Products\Product;
use App\Domain\Users\User;
use Tests\TestCase;

class BaseFeature extends TestCase
{
    protected function getUser()
    {
        return factory(User::class)->create();
    }

    protected function getUserToken()
    {
        $user = $this->getUser();

        return auth()->guard('api')
            ->login(User::whereEmail($user->email)->first());
    }

    protected function createCategories()
    {
        factory(Category::class, 10)
            ->create()
            ->each(function ($category) {
                $ids = factory(Product::class, 4)->create()->pluck('id');
                $category->products()->attach($ids);
            });
    }

    protected function createProducts()
    {
        factory(Product::class, 10)
            ->create();
    }
}
