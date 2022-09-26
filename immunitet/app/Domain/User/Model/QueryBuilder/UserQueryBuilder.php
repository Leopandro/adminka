<?php

declare(strict_types=1);

namespace App\Domain\User\Model\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class UserQueryBuilder extends Builder
{
    public function whereEmail(string $email): self
    {
        return $this->where(\DB::raw('LOWER(email)'), Str::lower($email));
    }

    public function whereLogin(string $login): self
    {
        return $this->where('login', $login);
    }
}
