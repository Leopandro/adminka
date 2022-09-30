<?php

namespace App\Http\Controllers;

use App\Domain\Payment\Model\Payment;
use App\Domain\SiteVerification\Model\SiteVerification;
use App\Domain\SiteVerification\Request\SiteVerificationEditRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

class SiteVerificationController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        /** @var Payment $payment */
        $siteVerification = SiteVerification::query()->where('user_id','=',auth('sanctum')->id())->firstOrFail();
        return $this->getSuccessResponse($siteVerification->toArray());
    }

    public function createOrUpdate(SiteVerificationEditRequest $request): JsonResponse
    {
        /** @var SiteVerification $payment */
        $siteVerification = SiteVerification::query()->where('user_id','=',auth('sanctum')->id())->first();
        if (!$siteVerification) {
            $siteVerification = new SiteVerification();
        }
        $siteVerification->verification_list = preg_split("/\r\n|\n|\r|;/", $request->get('verification_list'));
        if (count($siteVerification->verification_list) > Config::get('settings.max_items_count')) {
            throw ValidationException::withMessages(['verification_list' => 'Количество строк не должно быть больше '.Config::get('settings.max_items_count')]);
        }
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
