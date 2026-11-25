<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\FinanceCurrency;

/**
 * @OA\Schema(
 *     type="object",
 *     title="FinanceCurrencyResource",
 *     description="FinanceCurrency resource",
 *     @OA\Xml(
 *         name="FinanceCurrencyResource"
 *     )
 * )
 */
class FinanceCurrencyResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var FinanceCurrency[]
     */
    private $data;
}
