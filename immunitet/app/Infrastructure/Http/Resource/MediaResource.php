<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resource;

use App\Infrastructure\App\Env;
use App\Infrastructure\Media\Model\Media;
use App\Infrastructure\Http\Resource\JsonResource;

/**
 * Ресурс - файл
 */
class MediaResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param string $conversionName - Название сконвертированной версии (то, что делается в registerMediaConversions)
     * @return array
     */
    public function toArray($request, string $conversionName = ''): ?array
    {
        /** @var Media $media */
        $media = $this->resource;

        if (!$media) {
            return null;
        }

        // В тестовом окружении не нужно нарезать изображения
        // Соответственно, тут их не нужно отдавать
        if (Env::isTesting()) {
            $conversionName = '';
        }

        // Случается, что грузят файлы, название которых уже пропущено через urlencode
        // Такие файлы потом не скачать с CDN, приходится делать еще раз urlencode
        $url = $media->getFullUrl($conversionName);
        $urlParts = explode('/', $url);
        $urlParts[count($urlParts) - 1] = urlencode($urlParts[count($urlParts) - 1]);

        return [
            'id' => $media->id,
            'name' => $media->file_name,
            'size' => $media->getHumanReadableSizeAttribute(),
            'url' => implode('/', $urlParts),
        ];
    }
}
