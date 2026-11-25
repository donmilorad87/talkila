<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\StaticProfession;

/**
 * @OA\Schema(
 *     type="object",
 *     title="StaticProfessionResource",
 *     description="StaticProfession resource",
 *     @OA\Xml(
 *         name="StaticProfessionResource"
 *     )
 * )
 */
class StaticProfessionResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var StaticProfession[]
     */
    private $data;
}
