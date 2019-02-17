<?php

namespace App\Dtos\Response\Comment\Partials;

use App\Dtos\Response\AbstractPagedDto;
use App\Dtos\Response\Comment\CommentDetailsDto;

class CommentsDataSection extends AbstractPagedDto
{

    public static function build($pageMeta, $comments, $includeProduct = false, $includeUser = false)
    {

        $commentArrayList = [];
        foreach ($comments as $key => $comment) {
            $commentArrayList[] = CommentDetailsDto::build($comment, $includeProduct, $includeUser);
        }

        return [
            'page_meta' => $pageMeta,
            'comments' => $commentArrayList
        ];
    }

}
