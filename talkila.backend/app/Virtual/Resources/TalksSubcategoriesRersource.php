<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\TalksSubcategories;

/**
 * @OA\Schema(
 *     type="object",
 *     title="TalksSubcategoriesResource",
 *     description="TalksSubcategories resource",
 *     @OA\Xml(
 *         name="TalksSubcategoriesResource"
 *     )
 * )
 */
class TalksSubcategoriesResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var TalksSubcategories[]
     */
    private $data;
}
