<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\UserReported;

/**
 * @OA\Schema(
 *     type="object",
 *     title="UserReportedResource",
 *     description="UserReported resource",
 *     @OA\Xml(
 *         name="UserReportedResource"
 *     )
 * )
 */
class UserReportedResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var UserReported[]
     */
    private $data;
}
