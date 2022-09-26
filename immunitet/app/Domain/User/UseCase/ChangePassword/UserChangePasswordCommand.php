<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\ChangePassword;

use App\Domain\User\Model\User;
use App\Enum\EntityType;
use App\Infrastructure\Command\BaseCommand;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Команда изменения пароля пользователя
 */
class UserChangePasswordCommand extends BaseCommand
{

    public string $userUuid;
    public string $currentPassword;
    public string $newPassword;
    public string $confirmNewPassword;

    public static function getTitle(): string
    {
        return 'Изменение пароля пользователя';
    }

    public static function getCode(): string
    {
        return EntityType::USER . '.change-password';
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
        return [
            'userUuid' => 'required|uuid',
            'currentPassword' => sprintf('required|string|min:%d', config('settings.password_min_length')),
            'newPassword' => sprintf('required|string|min:%d', config('settings.password_min_length')),
            'confirmNewPassword' => sprintf('required|string|min:%d', config('settings.password_min_length')),
        ];
    }

    public function validateData(array $data): void
    {
        parent::validateData($data);

        /** @var User $user */
        $user = User::query()->findOrFail($data['userUuid']);

        if (!Hash::check($data['currentPassword'], $user->password)) {
            throw ValidationException::withMessages([
                'currentPassword' => \App\Infrastructure\Lang\Translator::translate('Текущий пароль введен неверно'),
            ]);
        }
    }
}
