<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource\Traits;

/**
 * Трейт для ресурсов листингов, которые возвращают заголовки
 */
trait HasListHeadersTrait
{
    /**
     * Возвращает массив заголовков для ресурсов листингов
     * @return array
     */
    public static function getHeaders(): array
    {
        return [];
    }
}
