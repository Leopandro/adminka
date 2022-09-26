<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\SetDemoPeriodEnd;

use App\Domain\User\Model\User;
use App\Infrastructure\Command\Handler\BaseCommandHandler;

class UserSetDemoPeriodEndCommandHandler extends BaseCommandHandler
{
    private UserSetDemoPeriodEndCommand $command;

    public function __construct(UserSetDemoPeriodEndCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): UserSetDemoPeriodEndCommand
    {
        return $this->command;
    }

    public function handle(): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($this->command->userId);
        $user->demo_period_end = null;
        $user->save();
    }
}
