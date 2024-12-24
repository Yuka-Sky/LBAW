<?php

namespace App\Policies;

use App\Models\User;

class BanPolicy
{
    /**
     * Determine if the user can ban another user.
     */
    public function create(User $authUser)
    {
        // Only admins can create bans
        return $authUser->is_admin;
    }

    /**
     * Determine if the user can remove a ban.
     */
    public function remove(User $authUser)
    {
        // Only admins can remove bans
        return $authUser->is_admin;
    }
}
