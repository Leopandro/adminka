<?php

namespace App\Domain\User\Model\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class NameSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $query->orderBy('surname', $descending ? 'desc' : 'asc')
            ->orderBy('name', $descending ? 'desc' : 'asc');
    }
}
