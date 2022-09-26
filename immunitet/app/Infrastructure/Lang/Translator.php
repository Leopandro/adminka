<?php

declare(strict_types=1);

namespace App\Infrastructure\Lang;

use App\Enum\EntityType;
use BenSampo\Enum\Enum;

class Translator
{
    public static function translate(string $langKey, array $params = [], $locale = null)
    {
        $translated = __($langKey, $params, $locale);

        // Ниже осуществляется проверка - удалось ли перевести строку (возможно, в языковом файле не указали перевод)
        // В этом случае перевод будет равен исходному ключу $langKey
        // Однако в ru.json все переводы такие, ключ равен переводу
        // Поэтому условно считаем, что там все хорошо и проверяем только ключи с точкой вроде enum.Gender.f
        $langKeyContainDots = strpos($langKey, '.') !== false && strpos($langKey, '.') !== strlen($langKey) - 1;

        if ($translated === $langKey && $langKeyContainDots) {
            \Log::warning(sprintf('Нет перевода для строки %s на язык %s', $langKey, \App::getLocale()));
        }

        return $translated;
    }

    public static function translateEnumValue(?Enum $enumValue): string
    {
        if (!$enumValue) {
            return '';
        }

        $enumClass = get_class($enumValue);

        return self::translate(sprintf('enum.%s.%s', substr($enumClass, strrpos($enumClass, '\\') + 1), $enumValue->value));
    }

    /**
     * Возвращает массив переводов названий атрибутов для команд, когда используется CommandValidatableInterface::getCustomAttributes()
     * @param EntityType $entityType
     * @param array $attributes
     * @return array
     */
    public static function translateCustomAttributes(EntityType $entityType, array $attributes): array
    {
        $result = [];

        foreach ($attributes as $attribute) {
            $result[$attribute] = self::translate("custom_attributes.{$entityType->value}.{$attribute}");
        }

        return $result;
    }

    /**
     * Возвращает перевод для заголовка таблицы в листинге
     * @param string $collectionClassName
     * @param string $headerName
     * @return string
     */
    public static function translateListResourceHeader(string $collectionClassName, string $headerName): string
    {
        return self::translate("list_headers.{$collectionClassName}.{$headerName}");
    }

    /**
     * Возвращает перевод для заголовка фильтра в листинге
     * @param string $collectionClassName
     * @param string $filterName
     * @return string
     */
    public static function translateListResourceFilter(string $collectionClassName, string $filterName): string
    {
        return self::translate("list_filters.{$collectionClassName}.{$filterName}");
    }

    /**
     * Возвращает перевод для плейсхолдера фильтра с поиском в листинге
     * @param string $collectionClassName
     * @param string $filterName
     * @return string
     */
    public static function translateListResourceFilterPlaceholder(string $collectionClassName, string $filterName): string
    {
        return self::translate("list_filter_placeholder.{$collectionClassName}.{$filterName}");
    }

    /**
     * Возвращает перевод для медиа коллекций
     * @param string $mediaCollectionName
     * @return string
     */
    public static function translateMediaCollectionName(string $mediaCollectionName): string
    {
        return self::translate("media_collections.{$mediaCollectionName}");
    }
}
