<?php

namespace App\Domain\User\Model\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class RoleSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        // Ничего не делает, т.к. у одного пользователя может быть несколько ролей
    }
}
