<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\EmailHistoriesLog;

/**
 * @OA\Schema(
 *     type="object",
 *     title="EmailHistoriesLogResource",
 *     description="EmailHistoriesLog resource",
 *     @OA\Xml(
 *         name="EmailHistoriesLogResource"
 *     )
 * )
 */
class EmailHistoriesLogResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var EmailHistoriesLog[]
     */
    private $data;
}
