<?php
namespace App\Domain\Company\Resource;

use App\Domain\Company\Model\Company;

class CompanyResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    public function toArray($request)
    {
        /** @var Company $company */
        $company = $this;
        return [
            'name' => $company->name,
            'inn' => $company->inn,
            'postcode' => $company->postcode,
            'city' => $company->city,
            'country_id' => $company->country_id,
            'address' => $company->address,
        ];
    }
}
