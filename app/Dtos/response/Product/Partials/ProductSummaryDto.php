<?php

namespace App\Dtos\Response\Product\Partials;

use App\Dtos\Response\User\Partials\UserUsernameAndPicDto;

class ProductSummaryDto
{

    public static function build($product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => (int)$product->price,
            'stock' => (int)$product->stock,
            'comments_count' => (int)$product->comments_count,
            'image_urls' => $product->images->pluck('file_path')
        ];
    }

}
