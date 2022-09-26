<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource;

use App\Infrastructure\Lang\Translator;
use BenSampo\Enum\Enum;

/**
 * Значение перечисления
 */
class MultiEnumResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \ReflectionException
     */
    public function toArray($request): ?array
    {
        /** @var Enum $enum */
        $enums = $this->resource;

        if (!$enums) {
            return null;
        }

        $result = [];
        foreach ($enums as $enum) {
            $enumClass = (new \ReflectionClass($enum))->getShortName();

            $langKey = sprintf('enum.%s.%s', $enumClass, $enum->value);

            $title = Translator::translate($langKey);

            $result[] = [
                'id' => $enum->value,
                'title' => $title === $langKey ? $enum->value : $title,
            ];
        }

        return $result;
    }
}
