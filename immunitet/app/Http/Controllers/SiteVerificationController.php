<?php

namespace App\Http\Controllers;

use App\Domain\Company\Model\Company;
use App\Domain\Company\Request\CompanyEditRequest;
use App\Domain\Company\Resource\CompanyResource;
use App\Domain\Payment\Model\Payment;
use App\Domain\Payment\Service\PaymentTransactionInfoService;
use App\Domain\SiteVerification\Model\SiteVerification;
use App\Enum\PaymentStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiteVerificationController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        /** @var Payment $payment */
        $siteVerification = SiteVerification::query()->where('user_id','=',auth('sanctum')->id())->firstOrFail();
        return $this->getSuccessResponse($siteVerification->toArray());
    }

    public function createOrUpdate(Request $request): JsonResponse
    {
        /** @var SiteVerification $payment */
        $siteVerification = SiteVerification::query()->where('user_id','=',auth('sanctum')->id())->first();
        if (!$siteVerification) {
            $siteVerification = new SiteVerification();
        }
        $siteVerification->verification_list = preg_split("/\r\n|\n|\r|;/", $request->get('verification_list'));
        $siteVerification->user_id = auth('sanctum')->id();
        $siteVerification->period = $request->get('period');
        $siteVerification->save();
        return $this->getSuccessResponse([]);
    }

    public function getPeriodList(Request $request)
    {
        $array = [
            [
                'type' => 'week',
                'label' => '1 раз в неделю'
            ],
            [
                'type' => 'day',
                'label' => '1 раз в день'
            ],
            [
                'type' => 'regular',
                'label' => 'Непрерывный (Рекомендовано)'
            ],
        ];
        return $this->getSuccessResponse($array);
    }
}
