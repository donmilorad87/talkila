<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\DisposalDomain;

/**
 * @OA\Schema(
 *     type="object",
 *     title="DisposalDomainResource",
 *     description="DisposalDomain resource",
 *     @OA\Xml(
 *         name="DisposalDomainResource"
 *     )
 * )
 */
class DisposalDomainResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var DisposalDomain[]
     */
    private $data;
}
