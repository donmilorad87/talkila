<?php

namespace App\Virtual\Resources;

/**
* @OA\Schema(
*     type="object",
*     title="BookingsPaymentDetailsApiResource",
 *     description="BookingsPaymentDetailsApi resource",
 *     @OA\Xml(
 *         name="BookingsPaymentDetailsApiResource"
 *     )
 * )
 */
class BookingsPaymentDetailsApiResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\BookingsPaymentDetailsApi[]
     */
    private $data;
}