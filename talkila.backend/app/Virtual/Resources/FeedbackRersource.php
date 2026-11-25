<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Feedback;

/**
 * @OA\Schema(
 *     type="object",
 *     title="FeedbackResource",
 *     description="Feedback resource",
 *     @OA\Xml(
 *         name="FeedbackResource"
 *     )
 * )
 */
class FeedbackResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Feedback[]
     */
    private $data;
}
