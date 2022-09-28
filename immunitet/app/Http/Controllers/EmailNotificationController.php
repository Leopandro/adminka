<?php

namespace App\Http\Controllers;

use App\Domain\EmailNotification\Model\EmailNotification;
use App\Domain\Payment\Model\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailNotificationController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        /** @var Payment $emailNotification */
        $emailNotification = EmailNotification::query()->where('user_id','=',auth('sanctum')->id())->firstOrFail();
        return $this->getSuccessResponse($emailNotification->toArray());
    }

    public function createOrUpdate(Request $request): JsonResponse
    {
        /** @var EmailNotification $emailNotification */
        $emailNotification = EmailNotification::query()->where('user_id','=',auth('sanctum')->id())->first();
        if (!$emailNotification) {
            $emailNotification = new EmailNotification();
        }
        $emailNotification->email_list = preg_split("/\r\n|\n|\r|;/", $request->get('email_list'));
        $emailNotification->user_id = auth('sanctum')->id();
        $emailNotification->period = $request->get('period');
        $emailNotification->save();
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
