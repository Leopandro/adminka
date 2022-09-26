<?php

namespace App\Domain\User\Service;

use App\Domain\Client\Model\Client;
use App\Infrastructure\Notification\BaseEmailNotification;

/**
 * Сервис для проверки возможности отправки уведомлений
 */
class NotificationCanBeSentChecker
{
    /**
     * @param mixed $instance
     * @param Client|null $client
     * @return bool
     */
    public static function canBeSent($instance, ?Client $client): bool
    {
        // [ Определяем нужно ли игнорировать "клиентов без уведомлений"
        $ignoreClientsWithoutNotice = false;

        if ($instance instanceof BaseEmailNotification) {
            $ignoreClientsWithoutNotice = $instance->ignoreClientsWithoutNotice;
        }

        if ($ignoreClientsWithoutNotice) {
            return true;
        }
        // ]

        // Не отправляем уведомления "клиентам без уведомлений"
        return ($client && $client->notifiable === true) || $client === null;
    }
}
