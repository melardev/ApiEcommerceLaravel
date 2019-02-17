<?php


namespace App\Dtos\response\Tag;


use App\Dtos\Response\Shared\PageMeta;
use App\Dtos\response\Tag\Partial\BasicTagDto;

class TagListDto
{

    public static function build($tags, $base_path = '/tags', $includeUrls = false)
    {
        $tagDtos = [];
        foreach ($tags->items() as $key => $tag) {
            $tagDtos[] = BasicTagDto::build($tag, $includeUrls);
        }

        return [
            'page_meta' => PageMeta::build($tags, $base_path),
            'tags' => $tagDtos
        ];

    }
}