<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Entity\Filter\Dashboard;

use App\Infrastructure\Http\Resource\EnumResource;
use BenSampo\Enum\Enum;
use RuntimeException;

/**
 * Фабрика элементов фильтров для админки (агентств, клиентов, сотрудников платформы)
 */
class DashboardFilterItemsFactory
{
    /**
     * Возвращает элементы фильтров для Enum классов
     * @param string $enumClassName
     * @return array
     */
    public static function getEnumItems(string $enumClassName): array
    {
        if (!is_subclass_of($enumClassName, Enum::class)) {
            throw new RuntimeException(sprintf('Класс %s не является потомком ' . Enum::class, $enumClassName));
        }

        return EnumResource::collection(array_values($enumClassName::getInstances()))->toArray(null);
    }
}
