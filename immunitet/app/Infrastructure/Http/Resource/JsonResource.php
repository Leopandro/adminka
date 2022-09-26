<?php

namespace App\Infrastructure\Http\Resource;

use App\Infrastructure\Http\Resource\Traits\HasListHeadersTrait;

/**
 * Переписан метод toArray чтобы для ресурса $this->resource === Null отдавал его как есть
 * и не приводил к пустому массиву
 */
class JsonResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    use HasListHeadersTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (is_null($this->resource)) {
            return null;
        }

        return is_array($this->resource)
            ? $this->resource
            : $this->resource->toArray();
    }

    public function jsonSerialize()
    {
        return $this->toArray(null);
    }
}
