<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\ChangePassword;

use App\Domain\User\Model\User;
use App\Infrastructure\Command\Handler\BaseCommandHandler;

/**
 * Обработчик команды изменения пароля пользователя
 */
class UserChangePasswordCommandHandler extends BaseCommandHandler
{

    protected UserChangePasswordCommand $command;

    public function __construct(UserChangePasswordCommand $command)
    {
        $this->command = $command;
    }

    public function getCommand(): UserChangePasswordCommand
    {
        return $this->command;
    }

    /**
     * @throws \Throwable
     */
    public function handle(): void
    {
        $command = $this->command;

        /** @var User $user */
        $user = User::query()->findOrFail($command->userUuid);
        $user->password = \Hash::make($command->newPassword);

        \DB::beginTransaction();
        try {
            $user->save();
            \DB::commit();
        } catch (\Throwable $exception) {
            \DB::rollBack();
            throw $exception;
        }
    }
}
