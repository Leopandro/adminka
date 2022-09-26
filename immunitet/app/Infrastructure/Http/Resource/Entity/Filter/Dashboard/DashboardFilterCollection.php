<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Entity\Filter\Dashboard;

use App\Infrastructure\Http\Resource\Entity\Filter\BaseFilterCollection;

abstract class DashboardFilterCollection extends BaseFilterCollection
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ReflectionException
     */
    public function __construct()
    {
        foreach (static::getInitData() as $data) {
            $data['collectionClassName'] = static::class;

            $filter = DashboardFilter::fromArray($data);
            $this->filters[$filter->id] = $filter;
        }
    }
}
