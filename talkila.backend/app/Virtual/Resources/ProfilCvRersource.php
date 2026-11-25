<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\ProfilCv;

/**
 * @OA\Schema(
 *     type="object",
 *     title="ProfilCvResource",
 *     description="ProfilCv resource",
 *     @OA\Xml(
 *         name="ProfilCvResource"
 *     )
 * )
 */
class ProfilCvResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var ProfilCv[]
     */
    private $data;
}
