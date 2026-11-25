<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\StaticMetric;

/**
 * @OA\Schema(
 *     type="object",
 *     title="StaticMetricResource",
 *     description="StaticMetric resource",
 *     @OA\Xml(
 *         name="StaticMetricResource"
 *     )
 * )
 */
class StaticMetricResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var StaticMetric[]
     */
    private $data;
}
