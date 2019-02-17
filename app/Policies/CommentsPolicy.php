<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the comment.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Comment $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user !== null;
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Comment $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return $user !== null && $user->id === $comment->user->id;
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Comment $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        foreach ($user->roles as $role) {
            if ($role->name === 'ROLE_ADMIN')
                return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the comment.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Comment $comment
     * @return mixed
     */
    public function restore(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the comment.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Comment $comment
     * @return mixed
     */
    public function forceDelete(User $user, Comment $comment)
    {
        //
    }
}
