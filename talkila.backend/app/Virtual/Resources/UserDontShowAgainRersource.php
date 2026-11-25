<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\UserDontShowAgain;

/**
 * @OA\Schema(
 *     type="object",
 *     title="UserDontShowAgainResource",
 *     description="UserDontShowAgain resource",
 *     @OA\Xml(
 *         name="UserDontShowAgainResource"
 *     )
 * )
 */
class UserDontShowAgainResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var UserDontShowAgain[]
     */
    private $data;
}
