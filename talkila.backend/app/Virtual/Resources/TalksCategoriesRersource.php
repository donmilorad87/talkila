<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\TalksCategories;

/**
 * @OA\Schema(
 *     type="object",
 *     title="TalksCategoriesResource",
 *     description="TalksCategories resource",
 *     @OA\Xml(
 *         name="TalksCategoriesResource"
 *     )
 * )
 */
class TalksCategoriesResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var TalksCategories[]
     */
    private $data;
}
