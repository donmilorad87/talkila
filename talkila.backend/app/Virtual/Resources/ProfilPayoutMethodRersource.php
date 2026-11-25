<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\ProfilPayoutMethod;

/**
 * @OA\Schema(
 *     type="object",
 *     title="ProfilPayoutMethodResource",
 *     description="ProfilPayoutMethod resource",
 *     @OA\Xml(
 *         name="ProfilPayoutMethodResource"
 *     )
 * )
 */
class ProfilPayoutMethodResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var ProfilPayoutMethod[]
     */
    private $data;
}
