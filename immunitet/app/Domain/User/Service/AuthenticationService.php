<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\Model\User;
use App\Infrastructure\Lang\Translator;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

/**
 * Класс-сервис для авторизации пользователя
 * Включает в себя поиск пользователя с переданным email, проверку статуса аккаунта и пароля,
 * выдачу пользователю нового токена
 */
class AuthenticationService
{
    public const DEFAULT_TOKEN_NAME = 'auth-token';
    public const EMULATOR_TOKEN_NAME = 'auth-emulator';

    /**
     * Метод ищет пользователя с заданным email, если пользователь есть, то
     * проверяем его статус и пароль. В случае ошибки кидаем соотвтствующий эксепшн
     *
     * @param string $login
     * @param string $passwordHash
     * @return User
     * @throws AuthenticationException
     */
    public function getUserByCredentials(string $login, string $passwordHash): User
    {
        /** @var User $user */
        $user = User::query()->whereLogin($login)->first();

        if ($user === null) {
            throw new AuthenticationException(Translator::translate('Неверный логин или пароль'));
        }

        if (!Hash::check($passwordHash, $user->password)) {
            throw new AuthenticationException(Translator::translate('Неверный логин или пароль'));
        }

        return $user;
    }

    public function createUserToken($user, string $name = self::DEFAULT_TOKEN_NAME): string
    {
        return $user->createToken($name)->plainTextToken;
    }

    public function revokeAuthTokens($user): void
    {
        $user->tokens()->delete();
    }

    /**
     * Метод для проверки возможности пользователя авторизоваться
     * Система авторизует только пользователей со статусом "Подтвержден"
     *
     * @param User $user
     * @throws AuthenticationException
     */
//    public function checkUserCanAuth(User $user): void
//    {
//        $this->commonCheckUserCanAuth($user);
//
//        if ($user->status->value === UserStatus::CONFIRMED_BUT_NEED_ADDITIONAL_CONFIRM) {
//            throw new AuthenticationException(
//                Translator::translate(
//                    'В ближайшее время менеджер платформы свяжется с Вами для открытия доступа в личный кабинет.'
//                )
//            );
//        }
//
//        if ($user->status->value !== UserStatus::CONFIRMED) {
//            throw new AuthenticationException(Translator::translate('Аккаунт пользователя не подтвержден.'));
//        }
//    }
}
