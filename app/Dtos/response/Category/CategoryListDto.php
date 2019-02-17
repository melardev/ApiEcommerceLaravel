<?php

namespace App\Dtos\response\Category;

use App\Dtos\response\Category\Partials\BasicCategoryDto;
use App\Dtos\Response\Shared\PageMeta;

class CategoryListDto
{

    public static function build($categories, $base_path = '/categories', $includeUrls = false)
    {
        $categoryDtos = array();

        foreach ($categories->items() as $key => $category) {
            $categoryDtos[] = BasicCategoryDto::build($category, $includeUrls);
        }

        return [
            'success' => true,
            'page_meta' => PageMeta::build($categories, $base_path),
            'categories' => $categoryDtos
        ];
    }
}