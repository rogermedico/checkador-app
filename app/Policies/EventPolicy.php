<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if($user->isAdmin())
        {
            return true;
        }
    }

    public function index(User $user)
    {
        return $user->isAdmin();
    }

    public function store(User $user, Event $event): bool
    {
        return $user->id === $event->user_id;
    }

    public function edit(User $user, Event $event): bool
    {
        return $user->id === $event->user_id;
    }

    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->user_id;
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->user_id;
    }
}
