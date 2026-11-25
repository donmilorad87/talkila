<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Talk;

/**
 * @OA\Schema(
 *     type="object",
 *     title="TalkResource",
 *     description="Talk resource",
 *     @OA\Xml(
 *         name="TalkResource"
 *     )
 * )
 */
class TalkResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Talk[]
     */
    private $data;
}
