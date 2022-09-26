<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\SendToCRMAccountRecover;

use App\Enum\CompanyIdentifierType;
use App\Enum\EntityType;
use App\Infrastructure\Command\BaseCommand;

class UserSendToCRMAccountRecoverCommand extends BaseCommand
{
    public ?string $documentValue;  // Название документа (ИНН, УПН...) \App\Enum\CompanyIdentifierType

    public ?string $documentTitle;  // Номер документа

    public ?string $contractNumber; // Номер договора

    public string $fullName; // Полное имя

    public string $email; // Емайл

    public ?string $reasons; // Причины

    public string $companyUuid;

    public static function getTitle(): string
    {
        return 'Отправка в CRM запроса на восстановление доступа к аккаунту';
    }

    public static function getCode(): string
    {
        return EntityType::USER . '.send-to-crm-account-recovery';
    }

    public static function getEntityType(): EntityType
    {
        return new EntityType(EntityType::USER);
    }

    public function getEntityId(): string
    {
        return $this->contractNumber ?? $this->documentValue;
    }

    public function getValidationRules(): array
    {
        return [
            'documentValue' => 'required_without:contractNumber|string|nullable',
            'documentTitle' => 'required_without:contractNumber|string|nullable',
            'contractNumber' => 'required_without:documentValue|string|nullable',
            'fullName' => 'required|string',
            'email' => 'required| email',
            'reasons' => 'present|string|nullable',
            'companyUuid' => 'required|uuid',
        ];
    }
}
