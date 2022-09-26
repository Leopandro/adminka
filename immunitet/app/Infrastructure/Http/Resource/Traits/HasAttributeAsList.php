<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Traits;

use Illuminate\Support\Arr;

/**
 * Трейт для ресурсов, у которых атрибуты являются листингами, требующими отправки headers и items
 */
trait HasAttributeAsList
{
    /**
     * @param $collection
     * @param string $jsonResourceClassName
     * @param array $exceptHeaders
     * @return array
     */
    private function getList($collection, string $jsonResourceClassName, array $exceptHeaders = []): array
    {
        return [
            'headers' => Arr::except($jsonResourceClassName::getHeaders(), $exceptHeaders),
            'items' => $jsonResourceClassName::collection($collection)->toArray(null),
        ];
    }
}
