<?php

declare(strict_types=1);

namespace App\Domain\User\Model\Traits;

use App\Infrastructure\Model\Cast\CountryCodeEnumCast;
use App\Infrastructure\Model\Cast\SocialNetworkCast;
use App\Infrastructure\Model\Cast\UserStatusCast;

trait UserMeta
{
    public function getFillable(): array
    {
        return [
            'name',
            'surname',
            'middlename',
            'country_code',
            'id',
            'email',
            'password',
            'status',
            'b24_id',
            'social_networks',
            'demo_period_end',
        ];
    }

    public function getHidden(): array
    {
        return [
            'password',
            'remember_token',
        ];
    }

    public function getCasts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'country_code' => CountryCodeEnumCast::class,
            'status' => UserStatusCast::class,
            'social_networks' => SocialNetworkCast::class,
            'demo_period_end' => 'datetime',
        ];
    }
}
