<?php
declare(strict_types=1);

namespace App\Domain\SiteVerification\Request;

use Illuminate\Foundation\Http\FormRequest;

class SiteVerificationEditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'verification_list' => 'required|string|max:512',
            'period' => 'required|string|max:64',
        ];
    }
}
