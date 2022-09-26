<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Entity\Filter\Catalog;

use App\Enum\FilterType;
use App\Infrastructure\Http\Resource\Entity\Filter\BaseFilterCollection;

abstract class CatalogFilterCollection extends BaseFilterCollection
{
    /**
     * @param array $currentFilters - Массив с текущими фильтрами.
     * @param array $aggregations - Массив агрегаций, полученный из эластика
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ReflectionException
     */
    public function __construct(array $currentFilters, array $aggregations)
    {
        foreach (static::getInitData() as $data) {
            $data['collectionClassName'] = static::class;
            $data['items'] = $this->getItemsByType($data['type'], $data['id'], $currentFilters, $aggregations);

            $filter = CatalogFilter::fromArray($data);
            $this->filters[$filter->id] = $filter;
        }
    }

    private function getItemsByType(FilterType $type, string $id, array $currentFilters, array $aggregations): array
    {
        switch ($type->value) {
            case FilterType::CHECKBOX_LIST:
                $items = CatalogFilterItemsFactory::buildCheckbox($id, $currentFilters, $aggregations);
                break;
            case FilterType::RADIO_BUTTON_LIST:
                $items = CatalogFilterItemsFactory::buildRadioButtonList($id, $currentFilters, $aggregations);
                break;
            case FilterType::NUMERIC_INTERVAL:
                $items = CatalogFilterItemsFactory::buildNumericRange($id, $currentFilters, $aggregations);
                break;
            case FilterType::DATE_INTERVAL:
            case FilterType::SPECIALISTS_AVAILABLE_DATE_RANGE:
                $items = CatalogFilterItemsFactory::buildDateRange($id, $currentFilters, $aggregations);
                break;
            case FilterType::DATE:
                $items = CatalogFilterItemsFactory::buildDate($id, $currentFilters, $aggregations);
                break;
            case FilterType::RADIO_BUTTON_YES_NO:
                $items = CatalogFilterItemsFactory::buildRadioButtonYesNo($id, $currentFilters, $aggregations);
                break;
            default:
                $items = [];
        }

        return $items;
    }
}
