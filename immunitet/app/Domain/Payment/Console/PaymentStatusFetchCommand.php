<?php
declare(strict_types=1);

namespace App\Domain\Payment\Console;

use App\Domain\Payment\Model\Payment;
use App\Enum\PaymentStatus;
use App\Infrastructure\ConsoleCommand\BaseConsoleCommand;
use Carbon\Carbon;

/**
 * Как только клиент переходит к оформлению заказа на специалистов в корзине
 * делается временная бронь, чтобы никто не положил их к себе в корзину, пока клиент оформляет заказ
 * Через некоторое время брони снимаются
 */
class PaymentStatusFetchCommand extends BaseConsoleCommand
{
    protected $signature = 'payment:payment-result-fetch';

    protected $description = 'Получение результатов об оплате';

    /**
     * @throws \Exception
     */
    public function handleInternal(): void
    {
        $payments = Payment::query()->where('status','=',PaymentStatus::CREATED)->get();
        foreach ($payments as $payment) {
            /** @var Payment $payment */
//            $payment->status = PaymentStatus::FAILED;
            $payment->updated_at = now();
            $payment->save();
        }
    }
}
