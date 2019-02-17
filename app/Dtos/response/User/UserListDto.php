<?php


namespace App\Dtos\Response\User;


use App\Dtos\Response\Users\partials\UserListDataSection;
use App\Dtos\Response\Shared\SuccessResponse;
use App\Dtos\Response\Shared\PageMeta;

class UserListDto
{
    public static function build($users, $base_path = '/products') {
        $userListDataSection = UserListDataSection::build(PageMeta::build($users, $base_path), $users->items());
        return array_merge(SuccessResponse::build(), [
            'data' => $userListDataSection
        ]);
    }
}