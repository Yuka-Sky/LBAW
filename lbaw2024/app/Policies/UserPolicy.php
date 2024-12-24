<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function anonymize(User $user, User $targetUser)
    {
        return $user->id === $targetUser->id || $user->is_admin;
    }

}
