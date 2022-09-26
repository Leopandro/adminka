<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Entity;

use App\Enum\ResourceFieldType;
use App\Infrastructure\Command\HydratesSelfFromArray;
use App\Infrastructure\Entity\ArrayAccessEntityInterface;
use App\Infrastructure\Lang\Translator;
use BenSampo\Enum\Rules\Enum;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * Заголовок
 */
class Header implements ArrayAccessEntityInterface
{
    use HydratesSelfFromArray;

    /**
     * Название заголовка. Должно совпадать с названием атрибута в items ресурса.
     * Т.е. если в ресурсе метод toArray() возвращает ключ 'status' => new EnumResource($team->status),
     * и для этого атрибута нужен заголовок, то название заголовка должно быть такое же (Header $header->name = 'status')
     * @var string
     */
    public string $name;

    /**
     * Название класса коллекции заголовков. Нужно, чтобы перевести заголовок колонки,
     * т.к. является ключом в языковых файлах skillstaff/resources/lang/ru/list_headers.php
     * @var string
     */
    public string $collectionClassName;

    /**
     * Тип поля
     * @var ResourceFieldType
     */
    public ResourceFieldType $type;

    /**
     * Поддерживается ли сортировка по данному заголовку
     * @var bool
     */
    public bool $sortable;

    /**
     * Должны ли записи под этим заголовком быть ссылкой
     * @var bool
     */
    public bool $link;

    /**
     * Правило сортировки по заголовку
     * @var AllowedSort|null
     */
    public ?AllowedSort $sort;

    /**
     * Правило фильтрации по заголовку
     * @var AllowedFilter|null
     */
    public ?AllowedFilter $filter;

    /**
     * Порядок отображения слева-направо. Чем больше значение, тем правее колонка.
     * @var int
     */
    public int $order;

    /**
     * @param array $data
     * @param bool $validate
     * @return Header
     * @throws ValidationException
     */
    public static function fromArray(array $data, bool $validate = true): Header
    {
        Validator::make($data, [
            'name' => 'required|string',
            'collectionClassName' => 'required|string',
            'type' => ['required', new Enum(ResourceFieldType::class)],
            'sortable' => 'required|boolean',
            'link' => 'required|boolean',
            'sort' => 'present|nullable',
            'filter' => 'present|nullable',
            'order' => 'required|integer',
        ])->validate();

        $header = new static();
        $header->hydrate($data);

        return $header;
    }

    public function toArray(): array
    {
        return [
            'text' => Translator::translateListResourceHeader($this->collectionClassName, $this->name),
            'type' => $this->type->value,
            'sortable' => $this->sortable,
            'order' => $this->order,
            'link' => $this->link,
        ];
    }
}
