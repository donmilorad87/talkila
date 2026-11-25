<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Pages;

/**
 * @OA\Schema(
 *     type="object",
 *     title="PagesResource",
 *     description="Pages resource",
 *     @OA\Xml(
 *         name="PagesResource"
 *     )
 * )
 */
class PagesResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Pages[]
     */
    private $data;
}
