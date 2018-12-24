<?php

namespace App\Domain\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/***
 * Class Category
 * @package App\Domain\Products
 * @property-read integer $id
 * @property string $name
 * @property string $description
 */
class Category extends Model
{
    public $timestamps = false;

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
