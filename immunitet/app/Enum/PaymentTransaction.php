<?php
namespace App\Enum;
use BenSampo\Enum\Enum;

class PaymentTransaction extends Enum
{
    public CONST ACCEPTED = "accepted";
    public CONST DECLINED = "declined";
    public CONST NEED_3D_SECURE = "need_3d_secure";
    public CONST UNKNOWN_ERROR = "unknown_error";
}
