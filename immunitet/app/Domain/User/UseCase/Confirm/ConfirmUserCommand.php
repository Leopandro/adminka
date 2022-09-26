<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Confirm;

use App\Enum\EntityType;
use App\Infrastructure\Command\BaseCommand;

/**
 * Команда для установки пользователю статуса "Подтвержден" и отметки
 * даты и времени подтверждения по email
 */
class ConfirmUserCommand extends BaseCommand
{
    public string $userUuid;

    public static function getTitle(): string
    {
        return 'Подтверждение аккаунта пользователя';
    }

    public static function getCode(): string
    {
        return EntityType::USER . '.confirm';
    }

    public static function getEntityType(): EntityType
    {
        return new EntityType(EntityType::USER);
    }

    public function getEntityId(): string
    {
        return $this->userUuid;
    }

    public function getValidationRules(): array
    {
        return ['userUuid' => 'required|uuid'];
    }
}
