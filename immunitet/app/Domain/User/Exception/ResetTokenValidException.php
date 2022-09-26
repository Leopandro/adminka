<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use App\Infrastructure\Exception\DisplayableExceptionInterface;
use App\Infrastructure\Lang\Translator;

class ResetTokenValidException extends UserException implements DisplayableExceptionInterface
{
    public function __construct()
    {
        $message = Translator::translate('Токен для сброса пароля недействителен или истекло время его действия');
        parent::__construct($message);
    }
}
