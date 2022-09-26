<?php

declare(strict_types=1);

namespace App\Domain\User\Resource;

use App\Domain\User\Model\User;
use App\Domain\User\Service\AuthenticationService;
use App\Infrastructure\Http\Resource\EnumResource;
use App\Infrastructure\Http\Resource\JsonResource;
use App\Infrastructure\Http\Resource\MediaResource;
use Carbon\Carbon;

class ProfileResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var User $user */
        $user = $this;

        $userAvatar = $user->getFirstMedia(Media::COLLECTION_USER_AVATAR);

        /** @var AgencyEmployee $agencyEmployee */
        $agencyEmployee = AgencyEmployee::query()
            ->select('id', 'agency_id')
            ->where('user_id', $user->id)
            ->first();

        /** @var ClientEmployee $clientEmployee */
        $clientEmployee = ClientEmployee::query()
            ->select('id', 'client_id', 'account_type')
            ->where('user_id', $user->id)
            ->first();

        /** @var AccountManager $accountManager */
        $accountManager = null;
        $contracted = null;
        $clientAccountType = null;
        $isRequestOffer = null;

        if ($agencyEmployee) {
            $contracted = $agencyEmployee->agency->hasSignedContract();
            $accountManager = $agencyEmployee->agency->managers()->with(['media'])->first();
        }

        if ($clientEmployee) {
            $contracted = $clientEmployee->client->hasSignedContract();
            $accountManager = $clientEmployee->client->managers()->with(['media'])->first();
            $clientAccountType = $clientEmployee->account_type->value;
            // Если у клиента есть договор, признак заявки-оферты равен false, иначе проверяем загружена ли заявка-оферта
            $isRequestOffer = $contracted ? false : isset($clientEmployee->client->requestOffer);
        }

        $managerPhones = [];
        $managerAvatar = null;
        $managerSocialNetworks = null;
        if ($accountManager) {
            $managerAvatar = $accountManager->getFirstMedia(Media::COLLECTION_USER_AVATAR);

            foreach ($accountManager->phones as $phone) {
                $managerPhones[] = new PhoneResource($phone);
            }

            foreach ($accountManager->social_networks as $socialNetwork) {
                $managerSocialNetworks[] = new SocialNetworkResource($socialNetwork);
            }
        }

        if ($user->demo_period_end) {
            $now = Carbon::now();
            if ($now->greaterThan($user->demo_period_end)) {
                $demoPeriodEndDays = 0 - $now->diffInDays($user->demo_period_end);
            } else {
                $demoPeriodEndDays = $user->demo_period_end->diffInDays($now) + 1;
            }
        } else {
            $demoPeriodEndDays = null;
        }

        return [
            'name' => $user->name,
            'surname' => $user->surname,
            'middlename' => $user->middlename,
            'email' => $user->email,
            'status' => $user->status->key,
            'status_data' => new EnumResource($user->status),
            'is_demo_period' => (bool)$user->demo_period_end,
            'demo_period_end_days' => $demoPeriodEndDays,
            'avatar' => $userAvatar === null ? '' : $userAvatar->getFullUrl(),
            'agency_id' => $agencyEmployee->agency_id ?? null,
            'agency_employee_id' => $agencyEmployee->id ?? null,
            'agency_country_code' => $agencyEmployee ? $agencyEmployee->agency->country_code : null,
            'client_id' => $clientEmployee->client_id ?? null,
            'client_employee_id' => $clientEmployee->id ?? null,
            'client_country_code' => $clientEmployee ? $clientEmployee->client->country_code : null,
            'client_account_type' => $clientAccountType,
            'roles' => $user->roles()->get(['roles.name'])->pluck('name')->toArray(),
            'verified' => $user->hasVerifiedEmail(),
            'contracted' => $contracted,
            'is_request_offer' => $isRequestOffer,
            'phones' => PhoneResource::collection($user->phones),
            'manager' => $accountManager ? [
                'name' => $accountManager->name,
                'middlename' => $accountManager->middlename,
                'surname' => $accountManager->surname,
                'photo' => new MediaResource($managerAvatar),
                'phones' => $managerPhones,
                'email' => $accountManager->email,
                'social_networks' => $managerSocialNetworks,
            ] : null,
            'is_auth_emulator' => $user->currentAccessToken()->name === AuthenticationService::EMULATOR_TOKEN_NAME,
            'company_name' => $agencyEmployee->agency->name ?? $clientEmployee->client->name ?? null,
        ];
    }
}
