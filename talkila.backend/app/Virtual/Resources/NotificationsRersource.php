<?php

namespace App\Virtual\Resources;

/**
* @OA\Schema(
*     type="object",
*     title="NotificationsResource",
 *     description="Notifications resource",
 *     @OA\Xml(
 *         name="NotificationsResource"
 *     )
 * )
 */
class NotificationsResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Notifications[]
     */
    private $data;
}