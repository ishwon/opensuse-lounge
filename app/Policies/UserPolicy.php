<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view their profile.
     */
    public function view(User $user, User $targetUser): bool
    {
        return $user->id === $targetUser->id &&
               $user->hasRole([UserRole::MEMBERSHIP, UserRole::ELECTION]);
    }

    /**
     * Determine whether the user can update their profile.
     */
    public function update(User $user, User $targetUser): bool
    {
        return $user->id === $targetUser->id &&
               $user->hasRole([UserRole::MEMBERSHIP, UserRole::ELECTION]);
    }
}
