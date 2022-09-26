<?php
namespace App\Domain\Payment\Service;

use App\Domain\Payment\Model\Payment;
use App\Domain\User\Model\User;
use App\Enum\PaymentTransaction;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PaymentService
{
    public function __construct(protected User $user, protected Payment $payment) {}
    public function initiatePayment(): array
    {
        $response = $this->post();
        return $this->handleResult($response);
    }

    protected function handleResult(object $response): array {
        if ($response->Success === true) {
            return [
                "status" => PaymentTransaction::ACCEPTED,
                "message" => "Транзакция принята"
            ];
        }
        if ($response->Success === false && isset($response->Model) && isset($response->Model->ReasonCode)) {
            return [
                "status" => PaymentTransaction::DECLINED,
                "message" => "Транзакция отклонена"
            ];
        }
        if ($response->Success === false && $response->Model) {
            return [
                "status" => PaymentTransaction::NEED_3D_SECURE,
                "message" => "Требуется 3-D Secure аутентификация",
                "urlRedirect" => $this->get3dSecureUrl($response->Model)
            ];
        }
        return [
            "status" => PaymentTransaction::UNKNOWN_ERROR,
            "message" => "Неизвестная ошибка"
        ];
    }

    protected function get3dSecureUrl(object $model): string
    {
        $url = $model->AcsUrl;
        $url .= '?MD='.$model->TransactionId;
        $url .= '&PaReq='.$model->PaReq;
        $url .= '&TermUrl='.$this->getFrontendUrl();
        return $url;
    }

    protected function getFrontendUrl(): string
    {
        return "http://".$_SERVER['SERVER_NAME']."/dashboard/payment?successPayment=true";
    }

    protected function post(): object
    {
        $client = new Client();
        $response = $client->post(
            'https://pk_c9dd7043c7eafce25cba83f4fe502:08c6d70ace905ed1a0876d8b185307e1@api.cloudpayments.ru/payments/cards/charge',
            [
                'form_params' =>
                    [
                        'CardCryptogramPacket' => $this->payment->payment_cryptogram,
                        'Amount' => 1,
                        'InvoiceId' => '',
                        'Currency' => 'RUB',
                        'IpAddress' => '77.40.48.136',
                    ]
            ]
        );
        return json_decode($response->getBody()->getContents());
    }
}
