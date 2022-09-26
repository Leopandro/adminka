<?php

namespace App\Http\Controllers;

use App\Domain\Payment\Model\Payment;
use App\Domain\Payment\Service\PaymentService;
use App\Domain\User\Model\User;
use Illuminate\Http\Request;
use Psy\Util\Str;

class PaymentController extends Controller
{
    public function create(Request $request) {
        /** @var User $user */
        $user = auth('sanctum')->user();
        $paymentUuid = (string)\Illuminate\Support\Str::orderedUuid();
        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->sum = $request->get('sum');
        $payment->payment_cryptogram = $request->get('payment_cryptogram');
        $payment->payment_uuid = $paymentUuid;
        $payment->currency = 'RUB';
        $payment->save();
        $paymentResult = (new PaymentService($user, $payment))->initiatePayment();
        return $this->getSuccessResponse($paymentResult);
    }
}
