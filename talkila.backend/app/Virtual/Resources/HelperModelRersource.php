<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\HelperModel;

/**
 * @OA\Schema(
 *     type="object",
 *     title="HelperModelResource",
 *     description="HelperModel resource",
 *     @OA\Xml(
 *         name="HelperModelResource"
 *     )
 * )
 */
class HelperModelResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var HelperModel[]
     */
    private $data;
}
