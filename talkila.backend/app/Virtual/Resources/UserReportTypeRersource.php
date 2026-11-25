<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\UserReportType;

/**
 * @OA\Schema(
 *     type="object",
 *     title="UserReportTypeResource",
 *     description="UserReportType resource",
 *     @OA\Xml(
 *         name="UserReportTypeResource"
 *     )
 * )
 */
class UserReportTypeResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var UserReportType[]
     */
    private $data;
}
