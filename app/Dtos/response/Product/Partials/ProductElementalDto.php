<?php

namespace App\Dtos\Response\Product\Partials;
class ProductElementalDto
{
    public static function build($product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
        ];
    }
}