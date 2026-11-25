<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Permission;

/**
 * @OA\Schema(
 *     type="object",
 *     title="PermissionResource",
 *     description="Permission resource",
 *     @OA\Xml(
 *         name="PermissionResource"
 *     )
 * )
 */
class PermissionResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Permission[]
     */
    private $data;
}
