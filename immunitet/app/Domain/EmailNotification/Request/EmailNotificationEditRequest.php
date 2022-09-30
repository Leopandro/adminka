<?php
declare(strict_types=1);

namespace App\Domain\EmailNotification\Request;

use Illuminate\Foundation\Http\FormRequest;

class EmailNotificationEditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email_list' => 'required|string|max:512',
            'period' => 'required|string|max:64',
        ];
    }
}
