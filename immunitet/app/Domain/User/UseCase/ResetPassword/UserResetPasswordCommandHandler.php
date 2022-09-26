<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\ResetPassword;

use App\Domain\PasswordResetToken\Service\PasswordResetService;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\Model\User;
use App\Domain\User\Service\AuthenticationService;
use App\Infrastructure\Command\Handler\BaseCommandHandler;
use App\Notifications\PasswordResetNotification;

/**
 * Обработчик команды сброса пароля пользователя
 */
class UserResetPasswordCommandHandler extends BaseCommandHandler
{
    private UserResetPasswordCommand $command;

    public function __construct(UserResetPasswordCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): UserResetPasswordCommand
    {
        return $this->command;
    }

    /**
     * @param AuthenticationService $authService
     * @param PasswordResetService $passwordResetService
     * @throws UserNotFoundException
     * @throws \Throwable
     */
    public function handle(
        AuthenticationService $authService,
        PasswordResetService $passwordResetService
    ): void {
        $command = $this->getCommand();

        /** @var User $user */
        $user = User::query()->whereEmail($command->email)->first();
        if (!$user) {
            throw new UserNotFoundException();
        }

        $token = $passwordResetService->generateResetPasswordToken($user);
        $passwordResetService->prepareUserForPasswordReset($user, $token);
        $resetPasswordLink = $passwordResetService->generateResetPasswordLink($token);

        $user->notify(new PasswordResetNotification($resetPasswordLink));
    }
}
