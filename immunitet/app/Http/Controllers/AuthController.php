<?php

namespace App\Http\Controllers;

use App\Domain\User\Model\User;
use App\Domain\User\Service\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
