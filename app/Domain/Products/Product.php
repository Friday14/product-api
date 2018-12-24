<?php

namespace App\Domain\Products;

use Illuminate\Database\Eloquent\Model;

/***
 * Class Product
 * @package App\Domain\Products
 * @property-read integer $id
 * @property string $name
 * @property string $description
 * @property integer $price
 */
class Product extends Model
{
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
