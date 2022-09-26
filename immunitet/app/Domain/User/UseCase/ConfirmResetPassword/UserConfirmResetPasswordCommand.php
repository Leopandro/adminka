<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\ConfirmResetPassword;

use App\Enum\EntityType;
use App\Infrastructure\Command\BaseCommand;
use Illuminate\Validation\Rule;

/**
 * Команда установки нового пароля пользователя после сброса
 */
class UserConfirmResetPasswordCommand extends BaseCommand
{
    public string $resetToken;

    public string $password;

    public static function getTitle(): string
    {
        return 'Установка нового пароля пользователя после сброса';
    }

    public static function getCode(): string
    {
        return EntityType::USER . '.confirm-reset-password';
    }

    public static function getEntityType(): EntityType
    {
        return new EntityType(EntityType::USER);
    }

    public function getEntityId(): string
    {
        return '-';
    }

    public function getValidationRules(): array
    {
        return [
            'resetToken' => 'required|string|size:32',
            'password' => sprintf('required|string|min:%d', config('settings.password_min_length')),
        ];
    }
}
