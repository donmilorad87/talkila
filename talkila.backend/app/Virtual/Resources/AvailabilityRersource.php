<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Availability;

/**
 * @OA\Schema(
 *     type="object",
 *     title="AvailabilityResource",
 *     description="Availability resource",
 *     @OA\Xml(
 *         name="AvailabilityResource"
 *     )
 * )
 */
class AvailabilityResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Availability[]
     */
    private $data;
}
