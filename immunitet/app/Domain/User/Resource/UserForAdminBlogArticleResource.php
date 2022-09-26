<?php

declare(strict_types=1);

namespace App\Domain\User\Resource;

use App\Domain\User\Model\User;
use App\Infrastructure\Http\Resource\JsonResource;

class UserForAdminBlogArticleResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var User $user */
        $user = $this->resource;

        return [
            'id' => $user->id,
            'name' => $user->full_name,
        ];
    }
}
