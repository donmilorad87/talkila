<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FinanceCurrencyResource extends JsonResource
{
    /**
     * @param mixed $resource
     */
    public function setResource($resource): void
    {
        $this->resource = $resource;
    }

    /**
     * @param array $with
     */
    public function setWith(array $with): void
    {
        $this->with = $with;
    }

    /**
     * @param array $additional
     */
    public function setAdditional(array $additional): void
    {
        $this->additional = $additional;
    }

    /**
     * @param string $wrap
     */
    public static function setWrap(string $wrap): void
    {
        self::$wrap = $wrap;
    }
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
