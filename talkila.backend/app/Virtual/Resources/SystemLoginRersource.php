<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\SystemLogin;

/**
 * @OA\Schema(
 *     type="object",
 *     title="SystemLoginResource",
 *     description="SystemLogin resource",
 *     @OA\Xml(
 *         name="SystemLoginResource"
 *     )
 * )
 */
class SystemLoginResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var SystemLogin[]
     */
    private $data;
}
