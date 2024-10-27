<?php

namespace App\Http\Resources\V1;

use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DateResource extends JsonResource
{
    /**
     * @property CarbonInterface $resource
     */
    public function toArray(Request $request): array
    {
        return [
            'human' => $this->resource->diffForHumans(),
            'string' => $this->resource->toIso8601String(),
            'local' => $this->resource->toDateTimeLocalString(),
            'timestamp' => $this->resource->timestamp,
        ];
    }
}
