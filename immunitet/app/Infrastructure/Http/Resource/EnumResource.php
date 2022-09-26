<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource;

use App\Infrastructure\Lang\Translator;
use BenSampo\Enum\Enum;

/**
 * Значение перечисления
 */
class EnumResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \ReflectionException
     */
    public function toArray($request = null): ?array
    {
        /** @var Enum $enum */
        $enum = $this->resource;

        if (!$enum) {
            return null;
        }

        // Если значение Enum содержит точку, удаляем её, т.к. хэлпер __() использует точку в качестве разделителя
        $enumValue = $enum->value;
        if (false !== strpos($enumValue, ".")) {
            $enumValue = str_replace('.', '', $enumValue);
        }

        $enumClass = (new \ReflectionClass($this->resource))->getShortName();

        $langKey = sprintf('enum.%s.%s', $enumClass, $enumValue);

        $title = Translator::translate($langKey);
        $translatingTypes = [
            'LanguageLevel',
            'Language',
            'EducationLevel',
        ];
        $result = [
            'id' => $enum->value,
            'title' => $title === $langKey ? $enum->value : $title,
        ];
        if (in_array($enumClass, $translatingTypes)) {
            $titleEn = Translator::translate($langKey, [], 'en');
            $result['title_en'] = $titleEn === $langKey ? $enum->value : $titleEn;
        }
        return $result;
    }

    public static function collection($resource, bool $keyByValue = false)
    {
        if ($keyByValue) {
            $resource = collect($resource)->keyBy('value');
        }

        return parent::collection($resource);
    }
}
