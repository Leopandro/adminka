<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\SetDemoPeriodStart;

use App\Domain\User\Model\User;
use App\Infrastructure\Command\Handler\BaseCommandHandler;
use Carbon\Carbon;

class UserSetDemoPeriodStartCommandHandler extends BaseCommandHandler
{
    private UserSetDemoPeriodStartCommand $command;

    public function __construct(UserSetDemoPeriodStartCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): UserSetDemoPeriodStartCommand
    {
        return $this->command;
    }

    public function handle(): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($this->command->userId);

        $user->demo_period_end = Carbon::parse($this->command->demoPeriodStartDate)
            ->addDays(config('params.demoPeriodDurationDays'));
        $user->save();
    }
}
