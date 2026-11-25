<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\StaticForbiddenName;

/**
 * @OA\Schema(
 *     type="object",
 *     title="StaticForbiddenNameResource",
 *     description="StaticForbiddenName resource",
 *     @OA\Xml(
 *         name="StaticForbiddenNameResource"
 *     )
 * )
 */
class StaticForbiddenNameResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var StaticForbiddenName[]
     */
    private $data;
}
