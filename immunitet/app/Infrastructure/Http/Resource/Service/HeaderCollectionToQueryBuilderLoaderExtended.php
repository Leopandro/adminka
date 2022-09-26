<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Service;

use App\Infrastructure\Http\Resource\Entity\HeaderCollection;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class HeaderCollectionToQueryBuilderLoaderExtended
{
    public function load(HeaderCollection $headerCollection, QueryBuilder $queryBuilder): void
    {
        $sorts = $headerCollection->getSorts();
        if (!array_key_exists('created_at', $sorts)) {
            $sorts['created_at'] = AllowedSort::field('created_at', $queryBuilder->getModel()->getTable() . '.created_at');
        }
        $queryBuilder->allowedFilters($headerCollection->getFilters())
            ->allowedSorts($sorts);
    }
}
