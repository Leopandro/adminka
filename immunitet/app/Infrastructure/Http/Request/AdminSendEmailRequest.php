<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Запрос на принудительную отправку письма пользователю из административного раздела
 */
class AdminSendEmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'employee_id' => 'required|uuid',
            'notification_type' => [
                'required',
                Rule::in([
                    'NeedEmailConfirmNotification',
                    'PasswordResetNotification',
                ]),
            ],
        ];
    }
}
