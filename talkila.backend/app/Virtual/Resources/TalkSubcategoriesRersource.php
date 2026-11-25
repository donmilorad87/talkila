<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\TalkSubcategories;

/**
 * @OA\Schema(
 *     type="object",
 *     title="TalkSubcategoriesResource",
 *     description="TalkSubcategories resource",
 *     @OA\Xml(
 *         name="TalkSubcategoriesResource"
 *     )
 * )
 */
class TalkSubcategoriesResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var TalkSubcategories[]
     */
    private $data;
}
