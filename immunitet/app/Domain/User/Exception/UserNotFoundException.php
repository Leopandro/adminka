<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use App\Infrastructure\Lang\Translator;

class UserNotFoundException extends UserException
{
    public function __construct()
    {
        parent::__construct(Translator::translate("Пользователь с указанным email не найден"));
    }
}
