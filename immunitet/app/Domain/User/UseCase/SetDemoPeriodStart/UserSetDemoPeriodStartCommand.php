<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\SetDemoPeriodStart;

use App\Enum\EntityType;
use App\Infrastructure\Command\BaseCommand;

class UserSetDemoPeriodStartCommand extends BaseCommand
{
    public string $userId;

    public string $demoPeriodStartDate;

    public static function getTitle(): string
    {
        return 'Установка начала демо-периода';
    }

    public static function getCode(): string
    {
        return EntityType::USER . '.set-demo-period-start';
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
            'demoPeriodStartDate' => 'required|date',
        ];
    }
}
