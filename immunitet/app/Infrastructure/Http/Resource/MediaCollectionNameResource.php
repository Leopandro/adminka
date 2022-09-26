<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource;

use App\Infrastructure\Lang\Translator;

/**
 * Ресурс - название медиа коллекции
 */
class MediaCollectionNameResource extends JsonResource
{
    public function toArray($request): ?array
    {
        /** @var string $mediaCollectionName */
        $mediaCollectionName = $this->resource;

        if (!$mediaCollectionName) {
            return null;
        }

        return [
            'id' => $mediaCollectionName,
            'title' => Translator::translateMediaCollectionName($mediaCollectionName),
        ];
    }
}
