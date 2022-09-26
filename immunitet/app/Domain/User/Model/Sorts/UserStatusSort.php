<?php

namespace App\Domain\User\Model\Sorts;

use App\Enum\UserStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Spatie\QueryBuilder\Sorts\Sort;

class UserStatusSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $statusesAsc = [];
        foreach (UserStatus::getValuesAsc() as $order => $value) {
            $statusesAsc[] = sprintf("('%s', %s)", $value, $order);
        }

        $statusesStr = implode(',', $statusesAsc);

        $table = $query->getQuery()->from;

        $query
            ->leftJoin('users', 'users.id', '=', $table . '.user_id')
            ->leftJoin(new Expression("(values{$statusesStr}) as us (code, ordering)"), 'users.status', '=', 'us.code')
            ->orderBy('us.ordering', $descending ? 'desc' : 'asc');
    }
}
