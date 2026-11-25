<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\SuggestionsHomeScreen;

/**
 * @OA\Schema(
 *     type="object",
 *     title="SuggestionsHomeScreenResource",
 *     description="SuggestionsHomeScreen resource",
 *     @OA\Xml(
 *         name="SuggestionsHomeScreenResource"
 *     )
 * )
 */
class SuggestionsHomeScreenResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var SuggestionsHomeScreen[]
     */
    private $data;
}
