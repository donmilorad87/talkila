<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\UserVisited;

/**
 * @OA\Schema(
 *     type="object",
 *     title="UserVisitedResource",
 *     description="UserVisited resource",
 *     @OA\Xml(
 *         name="UserVisitedResource"
 *     )
 * )
 */
class UserVisitedResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var UserVisited[]
     */
    private $data;
}
