<?php

namespace App\Dtos\Response\Comment\Partials;

class CommentsCountDto
{
    private $commentsCount;

    public static function build($comments): CommentsCountDto
    {
        $a = new CommentsCountDto();
        if ($comments == null)
            $a->setCommentsCount(0);
        else
            $a->setCommentsCount($comments->size());

        return $a;
    }

    public function getCommentsCount(): int
    {
        return $this->commentsCount;
    }

    public function setCommentsCount(int $commentsCount): void
    {
        $this->commentsCount = $commentsCount;
    }
}
