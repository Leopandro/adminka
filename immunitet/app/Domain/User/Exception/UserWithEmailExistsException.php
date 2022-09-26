<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use App\Infrastructure\Exception\DisplayableExceptionInterface;
use App\Infrastructure\Lang\Translator;

class UserWithEmailExistsException extends UserException implements DisplayableExceptionInterface
{
    public function __construct()
    {
        parent::__construct(Translator::translate('Пользователь с таким email уже зарегистрирован'));
    }
}
