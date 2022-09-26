<?php

namespace App\Domain\Payment\Service;

use App\Domain\Payment\Model\Payment;
use GuzzleHttp\Client;

class PaymentTransactionInfoService
{
    public function __construct(protected Payment $payment) {}

    public function getInfo() {

    }

    public function get() {
        $client = new Client();
        $response = $client->post(
            'https://pk_c9dd7043c7eafce25cba83f4fe502:08c6d70ace905ed1a0876d8b185307e1@api.cloudpayments.ru/payments/get',
            [
                'query' => [
                    'TransactionId' => $this->payment->transaction_id
                ]
            ]
        );
        return json_decode($response->getBody()->getContents());
    }
}
