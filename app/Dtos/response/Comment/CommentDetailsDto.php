<?php

namespace App\Dtos\Response\Comment;


use App\Dtos\Response\Product\Partials\ProductElementalDto;
use App\Dtos\Response\User\Partials\UserOnlyUsernameDto;
use App\Models\Comment;

class CommentDetailsDto
{

    public static function build(Comment $comment, $includeProduct = false, $includeUser = false)
    {
        $data = [
            // SuccessResponse::build(),
            'id' => $comment->id,
            'content' => $comment->content,
            'created_at' => $comment->createdAt,
            'updated_at' => $comment->updatedAt,
        ];

        if ($includeUser)
            $data['user'] = UserOnlyUsernameDto::build($comment->user);

        if ($includeProduct)
            $data['product'] = ProductElementalDto::build($comment->product);

        return $data;
    }

}

