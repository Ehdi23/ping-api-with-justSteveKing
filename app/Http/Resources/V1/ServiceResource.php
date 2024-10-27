<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\Link;
use TiMacDonald\JsonApi\JsonApiResource;

class ServiceResource extends JsonApiResource
{
    /**
     * @property Service $resource
     */
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'url' => $this->resource->url,
            'created' => new DateResource(
                resource: $this->resource->created_at
            ),
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'checks' => fn() => CheckResource::collection(
                resource: $this->whenLoaded(
                    relationship: 'checks',
                ),
            ),
        ];
    }

    public function toLinks(Request $request): array
    {
        return [
            Link::self(route('v1:services:show', $this->resource)),
        ];
    }
}
