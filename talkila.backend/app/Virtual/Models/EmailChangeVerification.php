<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="EmailChangeVerification",
 *     description="EmailChangeVerification model",
 *     @OA\Xml(
 *         name="EmailChangeVerification"
 *     )
 * )
 */

class EmailChangeVerification {
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;
}
