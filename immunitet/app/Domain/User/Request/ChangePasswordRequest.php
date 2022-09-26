<?php

declare(strict_types=1);

namespace App\Domain\User\Request;

use Illuminate\Foundation\Http\FormRequest;

/** Запрос на изменение пароля пользователя */
class ChangePasswordRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'currentPassword' => sprintf('required|string|min:%d', config('settings.password_min_length')),
            'newPassword' => sprintf('required|string|min:%d', config('settings.password_min_length')),
            'confirmNewPassword' => sprintf('required|string|min:%d', config('settings.password_min_length')),
        ];
    }
}
