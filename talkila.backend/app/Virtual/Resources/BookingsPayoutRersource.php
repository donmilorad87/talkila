<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\BookingsPayout;

/**
 * @OA\Schema(
 *     type="object",
 *     title="BookingsPayoutResource",
 *     description="BookingsPayout resource",
 *     @OA\Xml(
 *         name="BookingsPayoutResource"
 *     )
 * )
 */
class BookingsPayoutResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var BookingsPayout[]
     */
    private $data;
}
