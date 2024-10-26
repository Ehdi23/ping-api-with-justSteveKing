<?php

namespace App\Policies;

use App\Models\Check;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CheckPolicy
{

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Check $check): bool
    {
        return $check->service->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, Check $check): bool
    {
        return $check->service->user_id === $user->id;
    }

    public function delete(User $user, Check $check): bool
    {
        return $check->service->user_id === $user->id;
    }
}