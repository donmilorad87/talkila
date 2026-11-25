<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\UserBlocked;

/**
 * @OA\Schema(
 *     type="object",
 *     title="UserBlockedResource",
 *     description="UserBlocked resource",
 *     @OA\Xml(
 *         name="UserBlockedResource"
 *     )
 * )
 */
class UserBlockedResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var UserBlocked[]
     */
    private $data;
}
