<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Payout;

/**
 * @OA\Schema(
 *     type="object",
 *     title="PayoutResource",
 *     description="Payout resource",
 *     @OA\Xml(
 *         name="PayoutResource"
 *     )
 * )
 */
class PayoutResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Payout[]
     */
    private $data;
}
