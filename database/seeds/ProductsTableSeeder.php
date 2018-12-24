<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Domain\Products\Category::class, 10)
            ->create()
            ->each(function ($category) {
                $category->products()->saveMany(factory(\App\Domain\Products\Product::class, 5)->create());
            });
    }
}
