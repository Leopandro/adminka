<?php
declare(strict_types=1);

namespace App\Domain\Payment\Console;

use App\Domain\Payment\Model\Payment;
use App\Domain\Payment\Service\PaymentTransactionInfoService;
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
        /** @var Payment $payment */
        $payments = Payment::query()
            ->where('status','=',PaymentStatus::CREATED)
            ->where('created_at','<',Carbon::now()->subMinutes(3))
            ->get();
        foreach ($payments as $payment) {
            $result = (new PaymentTransactionInfoService($payment))->get();
            if ($result->Success) {
                $payment->status = PaymentStatus::SUCCESS;
            } else {
                $payment->status = PaymentStatus::FAILED;
            }
            $payment->save();
        }
    }
}
