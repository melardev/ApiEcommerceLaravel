<?php

namespace App\Dtos\Response\User\Partials;


use App\Dtos\Response\User\Partials\UserOnlyUsernameDto;

class UserListDataSection
{
    public static function build($pageMeta, $users)
    {
        $userDtos = [];
        foreach ($users as $key => $user) {
            $userDtos[] = UserOnlyUsernameDto::build($user);
        }
        return [
            'page_meta' => $pageMeta,
            'users' => $userDtos
        ];
    }
}