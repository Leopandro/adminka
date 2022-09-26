<?php

namespace App\Infrastructure\Http\Routing;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string route(string $name, array $parameters = [])
 */
class FrontendRouterFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FrontendRouter::class;
    }
}
