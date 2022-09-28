<?php

declare(strict_types=1);

namespace App\Domain\User\Request;

use Illuminate\Foundation\Http\FormRequest;

class RemindPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|exists:users|string|email|max:255',
        ];
    }
}
