<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\StaticBlockedUser;

/**
 * @OA\Schema(
 *     type="object",
 *     title="StaticBlockedUserResource",
 *     description="StaticBlockedUser resource",
 *     @OA\Xml(
 *         name="StaticBlockedUserResource"
 *     )
 * )
 */
class StaticBlockedUserResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var StaticBlockedUser[]
     */
    private $data;
}
