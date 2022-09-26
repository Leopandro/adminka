<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\ResetPassword;

use App\Enum\EntityType;
use App\Infrastructure\Command\BaseCommand;

/**
 * Команда сброса пароля пользователя
 */
class UserResetPasswordCommand extends BaseCommand
{
    public string $email;

    public static function getTitle(): string
    {
        return 'Сброс пароля пользователя';
    }

    public static function getCode(): string
    {
        return EntityType::USER . '.reset-password';
    }

    public static function getEntityType(): EntityType
    {
        return new EntityType(EntityType::USER);
    }

    public function getEntityId(): string
    {
        return $this->email;
    }

    public function getValidationRules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }
}
