<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->isAdmin();
    }

    public function show(User $user, User $eventsUser): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $eventsUser->id;
    }

    public function store(User $user, int $user_id): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $user_id;
    }

    public function edit(User $user, Event $event): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $event->user_id;
    }

    public function update(User $user, Event $event): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $event->user_id;
    }

    public function delete(User $user, Event $event): bool
    {
        if($user->isAdmin()) {
            return true;
        }

        return $user->id === $event->user_id;
    }
}
