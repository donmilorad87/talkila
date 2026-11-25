<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\TalkCategories;

/**
 * @OA\Schema(
 *     type="object",
 *     title="TalkCategoriesResource",
 *     description="TalkCategories resource",
 *     @OA\Xml(
 *         name="TalkCategoriesResource"
 *     )
 * )
 */
class TalkCategoriesResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var TalkCategories[]
     */
    private $data;
}
