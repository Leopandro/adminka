<?php

namespace App\Infrastructure\Http\Routing;

/**
 * Роутер для фроновых урлов
 * Просто route использовать не выходит, т.к. схема http|https
 * включается глобально, а она нужна нам только для фроновых роутов
 */
class FrontendRouter
{
    public function route(string $name, array $parameters = []): string
    {
        return env('SPA_URL') . route($name, $parameters, false);
    }
}
