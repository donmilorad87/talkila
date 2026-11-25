<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="BookingsPayout",
 *     description="BookingsPayout - model",
 *     @OA\Xml(
 *         name="BookingsPayout"
 *     )
 * )
 */
class BookingsPayout
{
// Swagger Deffinition

    /**
     * @OA\Property(
     *      title="id",
     *      description="id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $id;


    /**
     * @OA\Property(
     *      title="created_at",
     *      description="created_at - datetime",
     *      example=1,
     *      format="int64",
     *      type="string"
     * )
     *
     * @var \DateTime
     */

    public $created_at;


    /**
     * @OA\Property(
     *      title="updated_at",
     *      description="updated_at - datetime",
     *      example=1,
     *      format="int64",
     *      type="string"
     * )
     *
     * @var \DateTime
     */

    public $updated_at;


    /**
     * @OA\Property(
     *      title="deleted_at",
     *      description="deleted_at - datetime",
     *      example=1,
     *      format="int64",
     *      type="string"
     * )
     *
     * @var \DateTime
     */

    public $deleted_at;


    /**
     * @OA\Property(
     *      title="payouts_id",
     *      description="payouts_id - integer",
     *      example=1,
     *      format="int64"
     * )
     *
     * @var integer
     */

    public $payouts_id;


    /**
     * @OA\Property(
     *      title="bookings_id",
     *      description="bookings_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $bookings_id;


    /**
     * @OA\Property(
     *      title="payouts",
     *      description="payouts - Payout",
     *      type="object"
     * )
     *
     * @var \App\Virtual\Models\Payout
     */

    public $payouts;


}
