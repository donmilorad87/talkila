<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Country;

/**
 * @OA\Schema(
 *     type="object",
 *     title="CountryResource",
 *     description="Country resource",
 *     @OA\Xml(
 *         name="CountryResource"
 *     )
 * )
 */
class CountryResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Country[]
     */
    private $data;
}
