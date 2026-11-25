<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\UserBookmarkedTalks;

/**
 * @OA\Schema(
 *     type="object",
 *     title="UserBookmarkedTalksResource",
 *     description="UserBookmarkedTalks resource",
 *     @OA\Xml(
 *         name="UserBookmarkedTalksResource"
 *     )
 * )
 */
class UserBookmarkedTalksResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var UserBookmarkedTalks[]
     */
    private $data;
}
