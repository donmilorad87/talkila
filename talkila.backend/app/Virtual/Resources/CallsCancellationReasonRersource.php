<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\CallsCancellationReason;

/**
 * @OA\Schema(
 *     type="object",
 *     title="CallsCancellationReasonResource",
 *     description="CallsCancellationReason resource",
 *     @OA\Xml(
 *         name="CallsCancellationReasonResource"
 *     )
 * )
 */
class CallsCancellationReasonResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var CallsCancellationReason[]
     */
    private $data;
}
