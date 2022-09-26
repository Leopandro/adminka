<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Entity\Filter\Dashboard;

use App\Infrastructure\Http\Resource\Entity\Filter\BaseFilter;

/**
 * Фильтр для админки (агентства, клиента, сотрудника платформы)
 */
class DashboardFilter extends BaseFilter
{
    public static function fromArray(array $data, bool $validate = true): BaseFilter
    {
        if (array_key_exists('items', $data) && is_array($data['items'])) {
            $data['items'] = array_values($data['items']);
        }

        return parent::fromArray($data, $validate);
    }
}
