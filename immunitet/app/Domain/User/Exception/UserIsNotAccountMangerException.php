<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

/**
 * Исключение в случае отсутствия у Пользователя необходимых прав
 */
class UserIsNotAccountMangerException extends UserException
{
    public function __construct()
    {
        parent::__construct(\App\Infrastructure\Lang\Translator::translate(
            'Пользователь не является аккаунт-менеджером'
        ));
    }
}
