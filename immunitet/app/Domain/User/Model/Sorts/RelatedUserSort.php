<?php

namespace App\Domain\User\Model\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class RelatedUserSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $table = $query->getQuery()->from;
        $query
            ->leftJoin('users', 'users.id', '=', $table . '.user_id')
            ->orderBy('users.' . $property, $descending ? 'desc' : 'asc');
    }
}
