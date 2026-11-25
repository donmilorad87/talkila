<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\BillingAddress;

/**
 * @OA\Schema(
 *     type="object",
 *     title="BillingAddressResource",
 *     description="BillingAddress resource",
 *     @OA\Xml(
 *         name="BillingAddressResource"
 *     )
 * )
 */
class BillingAddressResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var BillingAddress[]
     */
    private $data;
}
