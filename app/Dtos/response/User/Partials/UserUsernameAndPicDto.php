<?php

namespace App\Dtos\Response\User\Partials;
class UserUsernameAndPicDto
{

    public static function build($user)
    {
        return [
            'id' => $user->id,
            'username' => $user->username
        ];
    }

}
