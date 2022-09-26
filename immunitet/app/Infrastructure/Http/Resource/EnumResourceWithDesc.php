<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource;

use Illuminate\Http\Request;

/**
 * Значение перечисления с описанием
 */
class EnumResourceWithDesc extends EnumResource
{
    /**
     * @param Request $request
     * @return array
     * @throws \ReflectionException
     */
    public function toArray($request = null): ?array
    {
        $result = parent::toArray($request);
        if ($result !== null) {
            $result['description'] = $this->resource->description;
        }

        return $result;
    }
}
