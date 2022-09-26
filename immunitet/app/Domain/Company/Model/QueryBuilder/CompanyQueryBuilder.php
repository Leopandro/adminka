<?php

declare(strict_types=1);

namespace App\Domain\Company\Model\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CompanyQueryBuilder extends Builder
{
    public function withCurrentUser(): self
    {
        return $this->where('user_id','=',auth('sanctum')->id());
    }
}
