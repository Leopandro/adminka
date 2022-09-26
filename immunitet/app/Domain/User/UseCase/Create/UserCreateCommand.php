<?php

namespace App\Domain\User\UseCase\Create;

use App\Enum\EntityType;
use App\Enum\UserStatus;
use App\Infrastructure\Command\BaseCommand;
use Carbon\Carbon;

class UserCreateCommand extends BaseCommand
{
    public string $id;

    public string $email;

    public string $password;

    public string $status;

    public string $name;

    public string $surname;

    public ?string $middlename;

    public Carbon $email_verified_at;

    public int $b24_id;

    public array $roles;

    public string $workPhone;

    public string $mobilePhone;

    public array $socialNetworks;

    public array $avatar;

    public ?Carbon $demo_period_end;

    public static function getTitle(): string
    {
        return 'Создание пользователя';
    }

    public static function getCode(): string
    {
        return EntityType::USER . '.create';
    }

    public static function getEntityType(): EntityType
    {
        return new EntityType(EntityType::USER);
    }

    public function getEntityId(): string
    {
        return $this->id;
    }

    public function getValidationRules(): array
    {
        return [
            'id' => 'required|uuid',
            'email' => 'required|email',
            'password' => sprintf('required|string|min:%d', config('settings.password_min_length')),
            'status' => 'required|string|enum_value:' . UserStatus::class,
            'name' => 'required|string',
            'surname' => 'required|string',
            'middlename' => 'nullable|string',
            'socialNetworks' => 'array',
            'workPhone' => 'phone',
            'mobilePhone' => 'phone',
            'avatar' => 'photoData',
        ];
    }
}
