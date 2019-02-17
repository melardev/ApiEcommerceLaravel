<?php

namespace App\Dtos\Response\Product;

use App\Dtos\response\Category\Partials\BasicCategoryDto;
use App\Dtos\Response\Comment\CommentDetailsDto;
use App\Dtos\response\Tag\Partial\BasicTagDto;

class ProductDetailsDto
{

    public static function build($product)
    {
        $commentDtos = [];
        foreach ($product->comments as $comment)
            $commentDtos[] = CommentDetailsDto::build($comment);
        $categoryDtos = [];
        foreach ($product->categories as $category)
            $categoryDtos[] = BasicCategoryDto::build($category);

        $tagDtos = [];
        foreach ($product->tags as $tag)
            $tagDtos[] = BasicTagDto::build($tag);

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'comments' => $commentDtos,
            'categories' => $categoryDtos,
            'tags' => $tagDtos,
            'views' => (int)$product->views,
            'image_urls' => $product->images->pluck('file_path')
        ];
    }


}
