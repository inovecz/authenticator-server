<?php

namespace App\Models\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait ResourceTrait
{
    protected string $resource;

    public function getResourceClass(): ?string
    {
        $path = explode('\\', __CLASS__);
        $resourceName = $this->resource ?? 'App\Http\Resources\\' . array_pop($path) . 'Resource';
        return class_exists($resourceName) ? $resourceName : null;
    }

    public function getResource(): ?JsonResource
    {
        $resourceClass = $this->getResourceClass();
        return $resourceClass ? new $resourceClass($this) : null;
    }
}
