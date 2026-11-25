<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\TalksBooking;

/**
 * @OA\Schema(
 *     type="object",
 *     title="TalksBookingResource",
 *     description="TalksBooking resource",
 *     @OA\Xml(
 *         name="TalksBookingResource"
 *     )
 * )
 */
class TalksBookingResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var TalksBooking[]
     */
    private $data;
}
