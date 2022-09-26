<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Entity\Filter;

use App\Domain\Specialist\Resource\Admin\FilterCollection\AdminArchivedSpecialistFilterCollection;
use App\Domain\Specialist\Resource\Admin\FilterCollection\AdminSpecialistFilterCollection;
use App\Domain\Specialist\Resource\FilterCollection\Catalog\CatalogSpecialistFilterCollection;
use App\Domain\Specialist\Resource\FilterCollection\Catalog\CatalogSpecialistFilterCollectionForUnauthorized;
use App\Domain\Specialist\Resource\FilterCollection\Catalog\CatalogVerifiedSpecialistFilterCollection;
use App\Domain\SpecialistTeam\Resource\FilterCollection\Catalog\CatalogSpecialistTeamFilterCollection;
use App\Domain\SpecialistTeam\Resource\FilterCollection\Catalog\CatalogSpecialistTeamFilterCollectionForUnauthorized;
use App\Enum\FilterType;
use App\Infrastructure\Command\HydratesSelfFromArray;
use App\Infrastructure\Entity\ArrayAccessEntityInterface;
use App\Infrastructure\Lang\Translator;
use BenSampo\Enum\Rules\Enum;
use Illuminate\Support\Facades\Validator;

/**
 * Фильтр
 */
class BaseFilter implements ArrayAccessEntityInterface
{
    use HydratesSelfFromArray;

    public string $id;

    public string $title;

    /**
     * Плейсхолдер для фильтров типа чекбокс с поиском
     * @var string
     */
    public string $placeholder;

    /**
     * Название класса коллекции фильтров. Нужно, чтобы перевести заголовок фильтров,
     * т.к. является ключом в языковых файлах skillstaff/resources/lang/ru/list_filters.php
     * @var string
     */
    public string $collectionClassName;

    public FilterType $type;

    public array $items;

    /**
     * @param array $data
     * @param bool $validate
     * @return BaseFilter
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ReflectionException
     */
    public static function fromArray(array $data, bool $validate = true): BaseFilter
    {
        Validator::make($data, static::getValidationRules())->validate();

        $filter = new static();
        $filter->hydrate($data);

        $collectionClassName = self::getCollectionClassNameForTranslate($filter);

        $filter->title = Translator::translateListResourceFilter($collectionClassName, $filter->id);
        $filter->placeholder = $filter->type->in(FilterType::getTypesWithSearchPlaceholder())
            ? Translator::translateListResourceFilterPlaceholder($collectionClassName, $filter->id)
            : '';
        return $filter;
    }

    /**
     * Возвращает правила валидации.
     * @return array
     */
    protected static function getValidationRules(): array
    {
        return [
            'id' => 'required|string',
            'collectionClassName' => 'required|string',
            'type' => ['required', new Enum(FilterType::class)],
            'items' => 'array',
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'filter_placeholder' => $this->placeholder,
            'type' => $this->type->value,
            'items' => $this->items,
        ];
    }

    /**
     * Подменяет некоторые коллекции фильтров, для получения правильных переводов
     * Некоторые классы коллекций фильтров наследуют другие и чтоб не дублировать
     * переводы написан этот метод подмены
     * @param BaseFilter $filter
     * @return string
     */
    private static function getCollectionClassNameForTranslate(BaseFilter $filter): string
    {
        $collectionClassName = $filter->collectionClassName;

        $conformity = [
            CatalogSpecialistFilterCollectionForUnauthorized::class => CatalogSpecialistFilterCollection::class,
            CatalogVerifiedSpecialistFilterCollection::class => CatalogSpecialistFilterCollection::class,
            CatalogSpecialistTeamFilterCollectionForUnauthorized::class => CatalogSpecialistTeamFilterCollection::class,
            AdminArchivedSpecialistFilterCollection::class => AdminSpecialistFilterCollection::class,
        ];

        return $conformity[$collectionClassName] ?? $collectionClassName;
    }
}
