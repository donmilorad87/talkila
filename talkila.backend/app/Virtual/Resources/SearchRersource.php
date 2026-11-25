<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Search;

/**
 * @OA\Schema(
 *     type="object",
 *     title="SearchResource",
 *     description="Search resource",
 *     @OA\Xml(
 *         name="SearchResource"
 *     )
 * )
 */
class SearchResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Search[]
     */
    private $data;
}
