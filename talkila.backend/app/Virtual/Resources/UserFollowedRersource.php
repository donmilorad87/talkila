<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\UserFollowed;

/**
 * @OA\Schema(
 *     type="object",
 *     title="UserFollowedResource",
 *     description="UserFollowed resource",
 *     @OA\Xml(
 *         name="UserFollowedResource"
 *     )
 * )
 */
class UserFollowedResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var UserFollowed[]
     */
    private $data;
}
