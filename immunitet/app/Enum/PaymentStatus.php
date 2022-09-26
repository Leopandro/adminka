<?php
namespace App\Enum;
use BenSampo\Enum\Enum;

class PaymentStatus extends Enum
{
    public const CREATED = 'created';
    public const SUCCESS = 'success';
    public const FAILED = 'failed';
}
