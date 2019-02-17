<?php

namespace App\Dtos\response\Category\Partials;

class BasicCategoryDto
{
    public static function build($category, $includeUrls = false)
    {
        $dto = [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
        ];

        if ($includeUrls)
            $dto['image_urls'] = $category->categoryImages->pluck('file_path');

        return $dto;
    }

}