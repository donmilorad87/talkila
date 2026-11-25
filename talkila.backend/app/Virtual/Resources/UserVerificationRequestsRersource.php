<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\UserVerificationRequests;

/**
 * @OA\Schema(
 *     type="object",
 *     title="UserVerificationRequestsResource",
 *     description="UserVerificationRequests resource",
 *     @OA\Xml(
 *         name="UserVerificationRequestsResource"
 *     )
 * )
 */
class UserVerificationRequestsResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var UserVerificationRequests[]
     */
    private $data;
}
