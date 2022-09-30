<?php

namespace App\Http\Controllers;

use App\Domain\Company\Model\Company;
use App\Domain\Company\Request\CompanyEditRequest;
use App\Domain\Company\Resource\CompanyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function getByUser(Request $request): JsonResponse
    {
        /** @var Company $company */
        $company = Company::query()
            ->where('user_id','=',auth('sanctum')->id())
            ->firstOrFail();
        return $this->getSuccessResponse((new CompanyResource($company))->toArray($request));
    }

    public function createOrUpdateByUser(CompanyEditRequest $request): JsonResponse
    {
        /** @var Company $company */
        if (!$company = Company::query()->withCurrentUser()->first()) {
            $company = new Company();
        }
        $company->fill($request->all());
        $company->user_id = auth('sanctum')->id();
        $company->saveOrFail();
        return $this->getSuccessResponse([]);
    }

    public function deleteByUser(Request $request): JsonResponse
    {
        /** @var Company $company */
        $company = Company::query()
            ->where('user_id','=',auth('sanctum')->id())
            ->first();
        $company->deleteOrFail();
        return $this->getSuccessResponse([]);
    }
}
