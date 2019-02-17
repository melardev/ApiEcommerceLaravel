<?php


namespace App\Dtos\response\Tag\Partial;


class BasicTagDto
{

    public static function build($tag, $includeUrls = false)
    {
        $dto = [
            'id' => $tag->id,
            'name' => $tag->name,
            'slug' => $tag->slug,
            'description' => $tag->description,
        ];
        if ($includeUrls) {
            $dto['image_urls'] = $tag->tagImages->pluck('file_path');
        }

        return $dto;
    }
}