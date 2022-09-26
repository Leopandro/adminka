<?php

declare(strict_types=1);

namespace App\Domain\User\Resource;

use App\Domain\Phone\Resource\PhoneResource;
use App\Domain\User\Model\User;
use App\Infrastructure\Http\Resource\EnumResource;
use App\Infrastructure\Http\Resource\MediaResource;
use App\Infrastructure\Media\Model\Media;
use App\Infrastructure\Http\Resource\JsonResource;

class UserInfoResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var User $user */
        $user = $this->resource;

        $userAvatar = $user->media->where('collection_name', Media::COLLECTION_USER_AVATAR)->first();

        $phones = [];
        foreach ($user->phones as $phone) {
            $phones[] = new PhoneResource($phone);
        }

        return [
            'name' => $user->name,
            'surname' => $user->surname,
            'middlename' => $user->middlename,
            'email' => $user->email,
            'phones' => $phones,
            'avatar' => new MediaResource($userAvatar),
            'status' => new EnumResource($user->status),
        ];
    }
}
