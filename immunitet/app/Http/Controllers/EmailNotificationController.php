<?php

namespace App\Http\Controllers;

use App\Domain\EmailNotification\Model\EmailNotification;
use App\Domain\EmailNotification\Model\EmailNotificationItem;
use App\Domain\EmailNotification\Request\EmailNotificationEditRequest;
use App\Domain\Payment\Model\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

class EmailNotificationController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        /** @var Payment $emailNotification */
        $emailNotification = EmailNotification::query()->where('user_id','=',auth('sanctum')->id())->firstOrFail();
        return $this->getSuccessResponse($emailNotification->toArray());
    }

    public function createOrUpdate(EmailNotificationEditRequest $request): JsonResponse
    {
        /** @var EmailNotification $emailNotification */
        $emailNotification = EmailNotification::query()->where('user_id','=',auth('sanctum')->id())->first();
        if (!$emailNotification) {
            $emailNotification = new EmailNotification();
        }
        $verification_list = preg_split("/\r\n|\n|\r|;/", $request->get('email_list'));
        if (count($verification_list) > Config::get('settings.max_items_count')) {
            throw ValidationException::withMessages(['verification_list' => 'Количество строк не должно быть больше '.Config::get('settings.max_items_count')]);
        } else {
        }
        $emailNotification->user_id = auth('sanctum')->id();
        $emailNotification->period = $request->get('period');
        $emailNotification->save();
        EmailNotificationItem::query()->where('email_list_id','=',$emailNotification->id)->delete();
        foreach ($verification_list as $item) {
            $emailNotificationItem = EmailNotificationItem::query()->create([
                'value' => $item,
                'email_list_id' => $emailNotification->id
            ]);
        }
        return $this->getSuccessResponse([]);
    }

    public function getPeriodList(Request $request)
    {
        $array = [
            [
                'type' => 'day',
                'label' => '1 раз в сутки'
            ],
            [
                'type' => 'regular',
                'label' => 'Незамедлительно (Рекомендовано)'
            ],
        ];
        return $this->getSuccessResponse($array);
    }
}
