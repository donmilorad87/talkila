<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\LanguagesProfil;

/**
 * @OA\Schema(
 *     type="object",
 *     title="LanguagesProfilResource",
 *     description="LanguagesProfil resource",
 *     @OA\Xml(
 *         name="LanguagesProfilResource"
 *     )
 * )
 */
class LanguagesProfilResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var LanguagesProfil[]
     */
    private $data;
}
