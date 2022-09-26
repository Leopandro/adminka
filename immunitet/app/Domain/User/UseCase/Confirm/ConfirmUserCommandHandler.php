<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Confirm;

use App\Domain\User\Model\User;
use App\Domain\User\Service\EmailVerificationService;
use App\Enum\UserStatus;
use App\Infrastructure\Command\CommandInterface;
use App\Infrastructure\Command\Handler\BaseCommandHandler;
use Carbon\Carbon;

/**
 * Обработчик команды подтверждения пользователя
 */
class ConfirmUserCommandHandler extends BaseCommandHandler
{
    protected ConfirmUserCommand $command;

    public function __construct(ConfirmUserCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): CommandInterface
    {
        return $this->command;
    }

    public function handle(EmailVerificationService $service): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($this->command->userUuid);

        if ($service->isUserSecondaryClientMasterAccount($user)) {
            $status = new UserStatus(UserStatus::CONFIRMED_BUT_NEED_ADDITIONAL_CONFIRM);
        } else {
            $status = new UserStatus(UserStatus::CONFIRMED);
        }

        $user->email_verified_at = Carbon::now();
        $user->status = $status;
        $user->save();
    }
}
