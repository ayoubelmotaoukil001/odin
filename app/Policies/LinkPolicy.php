<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Link; 
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true; 
    }

    public function view(User $user, Link $link): bool
    {
        return $user->id === $link->user_id || 
               $user->role === 'admin' ||
               $link->sharedWithUsers()->where('user_id', $user->id)->exists();
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function update(User $user, Link $link): bool
    {
        if ($user->id === $link->user_id || $user->role === 'admin') {
            return true;
        }

        return $link->sharedWithUsers()
                    ->where('user_id', $user->id)
                    ->wherePivot('permession', 'edit')
                    ->exists();
    }

    public function delete(User $user, Link $link): bool
    {
        return $user->id === $link->user_id || $user->role === 'admin';
    }

    public function restore(User $user, Link $link): bool
    {
        return $user->id === $link->user_id || $user->role === 'admin';
    }
}