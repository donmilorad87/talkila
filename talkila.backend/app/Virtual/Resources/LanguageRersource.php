<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Language;

/**
 * @OA\Schema(
 *     type="object",
 *     title="LanguageResource",
 *     description="Language resource",
 *     @OA\Xml(
 *         name="LanguageResource"
 *     )
 * )
 */
class LanguageResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Language[]
     */
    private $data;
}
