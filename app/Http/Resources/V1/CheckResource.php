<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

class CheckResource extends JsonApiResource
{
    /**
     * @property Check $resource
     */

    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'path' => $this->resource->path,
        ];
    }
}
