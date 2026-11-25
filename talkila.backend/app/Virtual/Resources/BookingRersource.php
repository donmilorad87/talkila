<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Booking;

/**
 * @OA\Schema(
 *     type="object",
 *     title="BookingResource",
 *     description="Booking resource",
 *     @OA\Xml(
 *         name="BookingResource"
 *     )
 * )
 */
class BookingResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Booking[]
     */
    private $data;
}
