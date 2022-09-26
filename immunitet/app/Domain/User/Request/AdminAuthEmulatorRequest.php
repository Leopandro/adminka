<?php

declare(strict_types=1);

namespace App\Domain\User\Request;

use Illuminate\Foundation\Http\FormRequest;

class AdminAuthEmulatorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'userId' => 'required|uuid',
        ];
    }
}
