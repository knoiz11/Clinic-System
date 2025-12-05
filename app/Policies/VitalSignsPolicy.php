<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VitalSign;

class VitalSignsPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, VitalSign $vitalSigns): bool
    {
        return true; // anyone logged in can view
    }

    public function create(User $user): bool
    {
        return true; // all logged users can create
    }

    public function update(User $user, VitalSign $vitalSigns): bool
    {
        return $user->id === $vitalSigns->user_id;
    }

    public function delete(User $user, VitalSign $vitalSigns): bool
    {
        return $user->id === $vitalSigns->user_id;
    }

    public function restore(User $user, VitalSign $vitalSigns): bool
    {
        return $user->id === $vitalSigns->user_id;
    }

    public function forceDelete(User $user, VitalSign $vitalSigns): bool
    {
        return $user->id === $vitalSigns->user_id;
    }
}
