<?php

declare(strict_types=1);

namespace App\Domain\User\Event;

use App\Domain\User\Model\User;

class UserSaved
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
