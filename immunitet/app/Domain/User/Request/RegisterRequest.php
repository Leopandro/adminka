<?php

declare(strict_types=1);

namespace App\Domain\User\Request;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => 'required|unique:users|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:4|max:255',
        ];
    }
}
