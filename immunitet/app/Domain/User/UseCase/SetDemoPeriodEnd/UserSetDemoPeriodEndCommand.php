<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\SetDemoPeriodEnd;

use App\Enum\EntityType;
use App\Infrastructure\Command\BaseCommand;

class UserSetDemoPeriodEndCommand extends BaseCommand
{
    public string $userId;

    public static function getTitle(): string
    {
        return 'Установка окончания демо-периода';
    }

    public static function getCode(): string
    {
        return EntityType::USER . '.set-demo-period-end';
    }

    public static function getEntityType(): EntityType
    {
        return new EntityType(EntityType::USER);
    }

    public function getEntityId(): string
    {
        return $this->userId;
    }

    public function getValidationRules(): array
    {
        return [
            'userId' => 'required|uuid',
        ];
    }
}
