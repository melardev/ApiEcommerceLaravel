<?php

namespace App\Dtos\Response\Comment;


use App\Dtos\Response\Comment\Partials\CommentsDataSection;
use App\Dtos\Response\Shared\PageMeta;
use App\Dtos\Response\Shared\SuccessResponse;


class CommentListDto
{

    public static function build($comments, $base_path = '/products', $includeProduct = false, $includeUser = false)
    {
        $commentsDataSection = CommentsDataSection::build(PageMeta::build($comments, $base_path), $comments->items(), $includeProduct, $includeUser);
        return array_merge(SuccessResponse::build(), [
            'data' => $commentsDataSection
        ]);
    }

}
