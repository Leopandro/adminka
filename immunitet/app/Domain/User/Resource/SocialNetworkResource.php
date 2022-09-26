<?php

declare(strict_types=1);

namespace App\Domain\User\Resource;

use App\Infrastructure\Entity\SocialNetwork;
use App\Infrastructure\Http\Resource\JsonResource;

class SocialNetworkResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var SocialNetwork $socialNetwork */
        $socialNetwork = $this->resource;

        return [
            'title' => $socialNetwork->title,
            'link' => $socialNetwork->link,
        ];
    }
}
