<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    /**
     * Check if user is admin
     */
    public function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Check if user is apprenant
     */
    public function isApprenant(User $user): bool
    {
        return $user->role === 'apprenant';
    }

    /**
     * Check if user is owner
     */
    public function isOwner(User $user, ?User $targetUser = null): bool
    {
        if (!$targetUser) {
            return true;
        }

        return $user->id === $targetUser->id;
    }
}
