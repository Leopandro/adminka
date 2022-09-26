<?php

declare(strict_types=1);

namespace App\Domain\User\Request;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => 'required|email',
            'password' => 'required|string',
        ];
    }
}
