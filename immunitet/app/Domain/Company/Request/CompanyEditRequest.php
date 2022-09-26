<?php
declare(strict_types=1);

namespace App\Domain\Company\Request;

use Illuminate\Foundation\Http\FormRequest;

class CompanyEditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'inn' => 'required|integer|regex:/^\d{10,12}$/',
            'name' => 'required|string|max:32',
            'postcode' => 'required|integer|digits_between:6,6',
            'country_id' => 'required|integer|exists:country,id',
            'city' => 'required|string|max:28',
            'address' => 'nullable|string|max:255',
        ];
    }
}
