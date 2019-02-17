<?php

namespace App\Observers;


use App\Models\Role;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        if ($user->roles()->count() == 0)
            $user->roles()->attach(Role::where('name', Role::ROLE_USER)->first());
    }

    public function updating(User $user): void
    {
        if ($user->roles()->count() == 0)
            $user->roles()->attach(Role::whereName(Role::ROLE_USER)->first());
    }
}