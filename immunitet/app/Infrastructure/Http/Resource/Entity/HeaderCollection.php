<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Entity;

use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use ReflectionException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * Коллекция заголовков для листингов
 */
abstract class HeaderCollection
{
    /**
     * @var Header[]
     */
    private array $headers;

    /**
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function __construct()
    {
        foreach ($this->getInitData() as $order => $data) {
            $this->prepareDataBeforeHeaderCreate($data, $order);
            $this->addHeader(Header::fromArray($data));
        }
    }

    /**
     * Возвращает массив с данными для инициализации коллекции.
     * Объявляется в наследниках. Представляет из себя массив массивов следующей структуры
     * [
     *  'name' => string, // Название заголовка
     *  'type' => App\Enum\ResourceFieldType, // Тип поля ресурса
     *  'sortable' => boolean, // Возможность сортировки
     *  'sort' => null|string|Spatie\QueryBuilder\Sorts\Sort, // Правило сортировки или название столбца в таблице БД
     *  'sortInternalName' => null|string, // Название столбца в таблице БД, для тех случаев, когда оно не совпадает с названием атрибута сортировки
     *  'filter' => null|callable, // Правило фильтрации
     *  ]
     * ВАЖНО! Порядок отображения на фронте будет соответствовать порядку элементов в возвращаемом массиве
     *
     * @return array
     */
    abstract protected function getInitData(): array;

    /**
     * Подготавливает данные перед созданием заголовка
     * @param array $data
     * @param int $order
     */
    protected function prepareDataBeforeHeaderCreate(array &$data, int $order): void
    {
        $data['collectionClassName'] = static::class;
        $data['order'] = $order;

        if ($data['filter']) {
            $data['filter'] = AllowedFilter::callback($data['name'], $data['filter']);
        }

        if ($data['sort']) {
            $data['sort'] = $this->getSort($data['name'], $data['sort'], $data['sortInternalName'] ?? null);
        }
    }

    /**
     * Формирует правило сортировки на основе переданных данных
     * @param string $name
     * @param $sort
     * @param $sortInternalName
     * @return AllowedSort
     */
    private function getSort(string $name, $sort, $sortInternalName): AllowedSort
    {
        if (is_string($sort)) {
            return AllowedSort::field($name, $sort);
        }

        return AllowedSort::custom($name, $sort, $sortInternalName);
    }

    /**
     * @param Header $header
     */
    protected function addHeader(Header $header): void
    {
        $this->headers[$header->name] = $header;
    }

    /**
     * Возвращает массив с описанием заголовков для фронта
     * @return array
     */
    public function getHeadersForListResource(): array
    {
        $headers = Arr::except($this->headers, $this->getExcludedHeaders());

        /** @var Header $header */
        foreach ($headers as $key => $header) {
            $headers[$key] = $header->toArray();
        }

        return $headers;
    }

    /**
     * Возвращает массив заголовков, которые нужно исключить из массива заголовков для фронта
     * Например для строки поиска нужно задать заголовок в коллекции и указать там же фильтр,
     * но отдавать на фронт заголовок search не нужно, т.к. на фронте в таблице нет такой колонки
     * @return array
     */
    protected function getExcludedHeaders(): array
    {
        return [];
    }

    /**
     * Возвращает массив правил сортировки
     * @return array
     */
    public function getSorts(): array
    {
        return collect($this->headers)->map(fn(Header $header) => $header->sort)->filter()->all();
    }

    /**
     * Возвращает массив правил фильтрации
     * @return array
     */
    public function getFilters(): array
    {
        return collect($this->headers)->map(fn(Header $header) => $header->filter)->filter()->all();
    }
}
