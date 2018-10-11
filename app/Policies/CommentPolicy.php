<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the user.
     *
     * @param User             $authenticatedUser
     * @param \App\Models\Comment $comment
     *
     * @return mixed
     *
     * @internal param \App\Models\User $user
     */
    public function view(User $authenticatedUser, Comment $comment)
    {
        if ($authenticatedUser->can('view posts')) {
            return true;
        }

        if ($authenticatedUser->can('view own posts')) {
            return $authenticatedUser->id === $comment->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param User             $authenticatedUser
     * @param \App\Models\Comment $comment
     *
     * @return mixed
     *
     * @internal param \App\Models\User $user
     */
    public function update(User $authenticatedUser, Comment $comment)
    {
        if ($authenticatedUser->can('edit posts')) {
            return true;
        }

        if ($authenticatedUser->can('edit own posts')) {
            return $authenticatedUser->id === $comment->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param User             $authenticatedUser
     * @param \App\Models\Comment $comment
     *
     * @return mixed
     *
     * @internal param \App\Models\User $user
     */
    public function delete(User $authenticatedUser, Comment $comment)
    {
        if ($authenticatedUser->can('delete posts')) {
            return true;
        }

        if ($authenticatedUser->can('delete own posts')) {
            return $authenticatedUser->id === $comment->user_id;
        }

        return false;
    }
}
