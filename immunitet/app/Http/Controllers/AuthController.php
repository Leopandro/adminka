<?php

namespace App\Http\Controllers;

use App\Domain\User\Model\User;
use App\Domain\User\Request\ChangePasswordRequest;
use App\Domain\User\Request\RegisterRequest;
use App\Domain\User\Request\RemindPasswordRequest;
use App\Domain\User\Service\AuthenticationService;
use App\Domain\User\UseCase\PasswordChanged\PasswordChangedEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Js;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;

class AuthController extends Controller
{
    /**
     * @throws \Illuminate\Auth\AuthenticationException
     */
    #[ArrayShape(['token' => "string"])]
    public function login(Request $request, AuthenticationService $service): array
    {
        $data = $request->all();

        $user = $service->getUserByCredentials($data['login'], $data['password']);
        $token = $service->createUserToken($user);

        return ['token' => $token];
    }

    #[ArrayShape(['user' => "array"])]
    public function user(Request $request): array
    {
        /** @var User $user */
        $user = auth('sanctum')->user();
        return [
            'user' => [
                'name' => $user->name,
                'surname' => $user->middle_name,
                'email' => $user->email
            ]
        ];
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = new User();
        $user->login = $request->get('login');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        if ($result = $user->save()) {
            return $this->getSuccessResponse([]);
        } else {
            return $this->getErrorResponse(["Ошибка"],422);
        }
    }

    public function remindPassword(RemindPasswordRequest $request): JsonResponse
    {
        $user = User::query()->where('email','=',$request->get('email'))->firstOrFail();
        $newPassword = Str::random(10);
        $user->password = bcrypt($newPassword);
        Mail::to($user->email)->send(new PasswordChangedEmail($user, $newPassword));
        if ($result = $user->save()) {
            return $this->getSuccessResponse([]);
        } else {
            return $this->getErrorResponse(["Ошибка"],422);
        }
    }

    protected function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()->where('id','=',auth('sanctum')->user()->id)->firstOrFail();
        if (!Hash::check($request->get('currentPassword'), $user->password)) {
            throw ValidationException::withMessages([
                'currentPassword' => \App\Infrastructure\Lang\Translator::translate('Текущий пароль введен неверно'),
            ]);
        }
        $user->password = bcrypt($request->get('newPassword'));
        $user->save();
        return $this->getSuccessResponse([]);
    }
}
