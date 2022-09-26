<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Service;

use App\Infrastructure\Http\Resource\Entity\HeaderCollection;
use Spatie\QueryBuilder\QueryBuilder;

class HeaderCollectionToQueryBuilderLoader
{
    public function load(HeaderCollection $headerCollection, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->allowedFilters($headerCollection->getFilters())
            ->allowedSorts($headerCollection->getSorts());
    }
}
