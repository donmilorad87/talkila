<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Role;

/**
 * @OA\Schema(
 *     type="object",
 *     title="RoleResource",
 *     description="Role resource",
 *     @OA\Xml(
 *         name="RoleResource"
 *     )
 * )
 */
class RoleResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Role[]
     */
    private $data;
}
