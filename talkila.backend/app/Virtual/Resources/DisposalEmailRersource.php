<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\DisposalEmail;

/**
 * @OA\Schema(
 *     type="object",
 *     title="DisposalEmailResource",
 *     description="DisposalEmail resource",
 *     @OA\Xml(
 *         name="DisposalEmailResource"
 *     )
 * )
 */
class DisposalEmailResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var DisposalEmail[]
     */
    private $data;
}
