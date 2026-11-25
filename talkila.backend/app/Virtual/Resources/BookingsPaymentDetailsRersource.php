<?php

namespace App\Virtual\Resources;

/**
* @OA\Schema(
*     type="object",
*     title="BookingsPaymentDetailsResource",
 *     description="BookingsPaymentDetails resource",
 *     @OA\Xml(
 *         name="BookingsPaymentDetailsResource"
 *     )
 * )
 */
class BookingsPaymentDetailsResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\BookingsPaymentDetails[]
     */
    private $data;
}