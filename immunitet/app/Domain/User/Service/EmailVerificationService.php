<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\Client\Model\Client;
use App\Domain\User\Model\User;
use App\Infrastructure\Http\Routing\FrontendRouterFacade;
use Illuminate\Database\Eloquent\Builder;

/**
 * Сервис для верификации аккаунта через email
 * Содержит метод генерации ссылки подтверждения email и метод активации аккаунта по ссылке
 */
class EmailVerificationService
{
    /**
     * Метод для генерации ссылок подтверждения email
     *
     * @param string $id
     * @param string $email
     * @return string
     */
    public static function generateVerificationLink(string $id, string $email): string
    {
        return FrontendRouterFacade::route('frontend.verify-email', [
            'userUuid' => $id,
            'hash' => sha1($email),
        ]);
    }

    public function checkUserVerificationHash($id, $hash): bool
    {
        $user = User::findOrFail($id);

        if (static::isHashValid($user->email, $hash)) {
            return true;
        }

        throw new \RuntimeException('Попытка подтвердить пользователя с использованием невалидного хеша');
    }

    private static function isHashValid($email, $hash): bool
    {
        return sha1($email) === $hash;
    }

    /**
     * Проверяет, является ли пользователь вторичным мастер-аккаунтом клиента, т.е
     * у клиента уже есть зарегистрированный сотрудник с правами мастер-аккаунта.
     * Если да, то далее пользователю должен выставиться статус "подтвержден, но требует дополнительного подтверждения"
     *
     * @param $user
     * @return bool
     */
    public function isUserSecondaryClientMasterAccount(User $user): bool
    {
        // Получаем компанию=клиента, сотрудником которой может быть данный пользователь
        $client = Client::whereHas('employees', static function (Builder $query) use ($user) {
            $query->where(['user_id' => $user->id]);
        })->first();

        // если клиент не найден, то пользователь не является сотрудником клиента
        if (is_null($client)) {
            return false;
        }

        // Выбираем первый зарегистрированный мастер-аккаунт
        $mainMasterAccount = $client->employees()->orderBy('created_at')->first();

        // Если идентификатор первого мастер-аккаунта равен идентификатору сотрудника,
        // то новый сотрудник это первый мастер-аккаунт
        if ($mainMasterAccount->user_id === $user->id) {
            return false;
        }

        return true;
    }
}
