<?php

namespace App\Http\Controllers;

use App\Domain\Company\Model\Company;
use App\Domain\Company\Request\CompanyEditRequest;
use App\Domain\Company\Resource\CompanyResource;
use App\Domain\Payment\Model\Payment;
use App\Domain\Payment\Service\PaymentTransactionInfoService;
use App\Enum\PaymentStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request): JsonResponse
    {
        return $this->getSuccessResponse([$_ENV]);
    }
}
