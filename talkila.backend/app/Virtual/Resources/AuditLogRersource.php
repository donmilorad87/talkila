<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\AuditLog;

/**
 * @OA\Schema(
 *     type="object",
 *     title="AuditLogResource",
 *     description="AuditLog resource",
 *     @OA\Xml(
 *         name="AuditLogResource"
 *     )
 * )
 */
class AuditLogResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var AuditLog[]
     */
    private $data;
}
