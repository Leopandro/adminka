<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Entity\Filter;

abstract class BaseFilterCollection
{
    /**
     * @var BaseFilter[]
     */
    protected array $filters;

    protected function addFilter(BaseFilter $filter): void
    {
        $this->filters[$filter->id] = $filter;
    }

    public function getFilterById(string $id): BaseFilter
    {
        if (!isset($this->filters[$id])) {
            throw new \RuntimeException("Фильтр {$id} не найден");
        }

        return $this->filters[$id];
    }

    public function toArray(): array
    {
        $resultData = [];

        $order = 1;

        foreach ($this->filters as $k => $filter) {
            $filterData = $filter->toArray();
            $filterData['order'] = $order++;
            $resultData[$k] = $filterData;
        }

        return $resultData;
    }

    /**
     * Возвращает массив с данными для инициализации коллекции.
     * Объявляется в наследниках. Конструктор наследника должен уметь
     * обрабатывать полученные в этом методе данные.
     * @return array
     */
    abstract protected static function getInitData(): array;

    /**
     * Возвращает названия всех фильтров
     * @param array $exceptFilters - Исключить эти фильтры из результата
     * @return array
     */
    public static function getIds(array $exceptFilters = []): array
    {
        return collect(static::getInitData())
            ->pluck('id')
            ->filter(fn ($id) => !in_array($id, $exceptFilters, true))
            ->all();
    }
}
