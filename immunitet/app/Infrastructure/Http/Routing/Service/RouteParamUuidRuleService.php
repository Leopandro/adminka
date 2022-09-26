<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Routing\Service;

/**
 * Сервис для получения правил валидации UUID в параметрах роутов
 */
class RouteParamUuidRuleService
{
    /**
     * Формирует правила для валидации UUID в параметрах роутов
     * @param ...$params - названия параметров из URL, которые должны являться UUID
     * @return array - массив правил для метода Illuminate\Support\Facades\Route::where()
     */
    public static function getRulesForParams(...$params): array
    {
        $rules = [];

        foreach ($params as $param) {
            $rules[$param] = '^[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$';
        }

        return $rules;
    }
}
