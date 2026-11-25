<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\EmailChangeVerification;

/**
 * @OA\Schema(
 *     type="object",
 *     title="EmailChangeVerificationResource",
 *     description="EmailChangeVerification resource",
 *     @OA\Xml(
 *         name="EmailChangeVerificationResource"
 *     )
 * )
 */
class EmailChangeVerificationResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var EmailChangeVerification[]
     */
    private $data;
}
