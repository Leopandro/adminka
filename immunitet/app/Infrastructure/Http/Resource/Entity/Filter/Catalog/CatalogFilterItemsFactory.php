<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Entity\Filter\Catalog;

use App\Domain\Specialist\Resource\FilterCollection\Catalog\CatalogSpecialistFilterCollection;
use App\Infrastructure\Lang\Translator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Фабрика элементов фильтров.
 * В зависимости от типа фильтра строит массив элементов на основе текущих фильтров
 * и агрегаций из эластика
 */
class CatalogFilterItemsFactory
{
    public static function buildCheckbox(string $key, array $filters, array $data): array
    {
        $result = [];

        // Когда фильтр по полям с типом keyword данные находятся на другом уровне вложенности
        $data = $data[$key][$key][$key]['buckets'] ?? $data[$key][$key]['buckets'];

        foreach ($data as $bucket) {
            $id = Str::after($bucket['key'], '||');

            $item = [
                'id' => $id,
                'title' => Str::before($bucket['key'], '||'),
                'doc_count' => $bucket['doc_count'],
                'active' => $bucket['doc_count'] > 0,
                'selected' => in_array($id, $filters[$key] ?? [], true),
            ];

            // Если пользователь очень быстро кликнул на два
            // фильтра, до того, как первый запрос отработал и убрал
            // несуществующие комбинации фильтров
            // то мы должны показать ему чекбокс, который он кликнул
            // чтобы у него была возможность его снять
            if ($item['doc_count'] === 0 && !$item['selected']) {
                continue;
            }

            $result[] = $item;
        }

        return array_values($result);
    }

    public static function buildRadioButtonList(string $key, array $filters, array $data): array
    {
        $elasticKey = $key;
        if ($key === CatalogSpecialistFilterCollection::ID_CATEGORY_SLUG) {
            $elasticKey = 'categories';
        }

        $current = $filters[$key] ?? null;

        $result = [];

        // Когда фильтр по полям с типом keyword данные находятся на другом уровне вложенности
        $buckets = $data[$elasticKey][$elasticKey][$elasticKey]['buckets'] ?? $data[$elasticKey][$elasticKey]['buckets'];

        foreach ($buckets as $bucket) {
            if ($bucket['doc_count'] <= 0) {
                continue;
            }

            $id = Str::after($bucket['key'], '||');

            $item = [
                'id' => $id,
                'title' => Str::before($bucket['key'], '||'),
                'doc_count' => $bucket['doc_count'],
                'active' => $bucket['doc_count'] > 0,
                'selected' => $id === $current,
            ];

            $result[] = $item;
        }

        $result = Arr::prepend($result, [
            'id' => null,
            'title' => Translator::translate('Все'),
            'doc_count' => $data[$elasticKey]['doc_count'] ?? 0,
            'active' => true,
            'selected' => null === $current,
        ]);

        return array_values($result);
    }

    public static function buildNumericRange(string $key, array $filters, array $data): array
    {
        $keys = ['from', 'to'];

        $result = [];

        foreach ($keys as $keyName) {
            $value = $filters[$key][$keyName] ?? null;
            $valKey = $keyName === 'from' ? 'min_value' : 'max_value';
            $result[$keyName] = [
                'value' => is_null($value) ? $value : (int)$value,
                $valKey => (int)$data["{$key}_{$keyName}"]["{$key}_{$keyName}"]['value'],
            ];
        }

        return $result;
    }

    public static function buildDateRange(string $key, array $filters, array $data): array
    {
        $keys = ['from' => 'min_value', 'to' => 'max_value'];

        $result = [];

        foreach ($keys as $keyName => $valueName) {
            $result[$keyName] = [
                'value' => $filters[$key][$keyName] ?? null,
                $valueName => null,
            ];
        }

        return $result;
    }

    public static function buildDate(string $key, array $filters, array $data): array
    {
        return [];
    }

    public static function buildRadioButtonYesNo(string $key, array $filters, array $data): array
    {
        $result = [];

        $current = array_key_exists($key, $filters) ? $filters[$key] : '';

        $ids = [
            Translator::translate('Да') => true,
            Translator::translate('Нет') => false,
            Translator::translate('Не важно') => null,
        ];

        foreach ($ids as $title => $id) {
            $result[] = [
                'id' => $id,
                'title' => $title,
                'selected' => $current === $id,
                'doc_count' => self::getDocCountForRadioButtonYesNo($data, $key, $id),
                'active' => true,
            ];
        }

        return $result;
    }

    private static function getDocCountForRadioButtonYesNo(array $data, string $key, ?bool $id): int
    {
        if ($id === null) {
            return $data[$key]['doc_count'] ?? 0;
        }

        $buckets = $data[$key][$key]['buckets'] ?? $data[$key][$key][$key]['buckets'] ?? [];

        $bucket = Arr::first($buckets, static fn(array $item) => $item['key'] === (int)$id);

        return $bucket['doc_count'] ?? 0;
    }
}
