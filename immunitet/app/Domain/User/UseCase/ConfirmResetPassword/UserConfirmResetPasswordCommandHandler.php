<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\ConfirmResetPassword;

use App\Domain\PasswordResetToken\Model\PasswordResetToken;
use App\Domain\PasswordResetToken\Service\PasswordResetService;
use App\Domain\User\Exception\ResetTokenValidException;
use App\Enum\UserStatus;
use App\Infrastructure\Command\Handler\BaseCommandHandler;

/**
 * Обработчик команды установки нового пароля пользователя после сброса
 */
class UserConfirmResetPasswordCommandHandler extends BaseCommandHandler
{
    protected UserConfirmResetPasswordCommand $command;

    public function __construct(UserConfirmResetPasswordCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): UserConfirmResetPasswordCommand
    {
        return $this->command;
    }

    /**
     * @param PasswordResetService $passwordResetService
     * @throws \Throwable
     */
    public function handle(PasswordResetService $passwordResetService): void
    {
        $command = $this->getCommand();

        /** @var PasswordResetToken $resetToken */
        $resetToken = PasswordResetToken::query()->whereActiveToken($command->resetToken)->first();
        if (!$resetToken) {
            throw new ResetTokenValidException();
        }

        $user = $resetToken->user;
        $user->password = \Hash::make($command->password);

        // Если пароль устанавливает пользователь с неподтвержденным статусом (такое возможно при создании суб-аккаунта клиентом)
        // устанавливаем статус CONFIRMED, т.к. пароль устанавливается посредством почты и general или master сами создали аккаунт
        // (от него дополнительного подтверждения не требуется)
        if ($user->status->isNot(UserStatus::CONFIRMED())) {
            $user->status = UserStatus::CONFIRMED();
            $user->email_verified_at = $user->email_verified_at ?? now();
        }

        \DB::beginTransaction();
        try {
            $user->save();
            $passwordResetService->deactivateOldUserTokens($user->id);
            \DB::commit();
        } catch (\Throwable $exception) {
            \DB::rollBack();
            throw $exception;
        }
    }
}
