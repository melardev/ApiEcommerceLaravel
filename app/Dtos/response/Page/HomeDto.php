<?php


namespace App\Dtos\response\Page;


use App\Dtos\response\Category\Partials\BasicCategoryDto;
use App\Dtos\response\Tag\Partial\BasicTagDto;

class HomeDto
{
    public static function build($tags, $categories, $includeUrls = true)
    {
        foreach ($tags as $key => $category) {
            $tagDtos[] = BasicTagDto::build($category, $includeUrls, $includeUrls);
        }

        foreach ($categories as $key => $category) {
            $categoryDtos[] = BasicCategoryDto::build($category, $includeUrls, $includeUrls);
        }
        return [
            'tags' => $tagDtos,
            'categories' => $categoryDtos,
        ];
    }
}