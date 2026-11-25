<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="Booking",
 *     description="Booking - model",
 *     @OA\Xml(
 *         name="Booking"
 *     )
 * )
 */
class Booking
{
// Swagger Deffinition

    /**
     * @OA\Property(
     *      title="id",
     *      description="id - integer",
     *      example=1,
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $id;


    /**
     * @OA\Property(
     *      title="state",
     *      description="state - int",
     *      example=1,
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $state;


    /**
     * @OA\Property(
     *      title="extension",
     *      description="extension - int",
     *      example=1,
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $extension;


    /**
     * @OA\Property(
     *      title="anonym",
     *      description="anonym - int",
     *      example=1,
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $anonym;


    /**
     * @OA\Property(
     *      title="start_call",
     *      description="start_call - datetime",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */

    public $start_call;


    /**
     * @OA\Property(
     *      title="end_call",
     *      description="end_call - datetime",
     *      example="2020-01-27 17:50:45",
     *      format="datetime",
     *      type="string"
     * )
     *
     * @var \DateTime
     */

    public $end_call;


    /**
     * @OA\Property(
     *      title="duration",
     *      description="duration - int",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var integer
     */

    public $duration;


    /**
     * @OA\Property(
     *      title="price",
     *      description="price - decimal",
     *      example=44.22,
     *      type="number"
     * )
     *
     * @var number
     */

    public $price;


    /**
     * @OA\Property(
     *      title="message",
     *      description="message - text",
     *      example="Message",
     *      type="string"
     * )
     *
     * @var string
     */

    public $message;


    /**
     * @OA\Property(
     *      title="created_at",
     *      description="created_at - datetime",
     *      example="2020-01-27 17:50:45",
     *      format="datetime",
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
     *      example="2020-01-27 17:50:45",
     *      format="datetime",
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
     *      example="2020-01-27 17:50:45",
     *      format="datetime",
     *      type="string"
     * )
     *
     * @var \DateTime
     */

    public $deleted_at;


    /**
     * @OA\Property(
     *      title="participant_user_id",
     *      description="participant_user_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $participant_user_id;


    /**
     * @OA\Property(
     *      title="finance_currencies_id",
     *      description="finance_currencies_id - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $finance_currencies_id;


    /**
     * @OA\Property(
     *      title="cancellation_reason_id",
     *      description="cancellation_reason_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $cancellation_reason_id;


    /**
     * @OA\Property(
     *      title="talksBookingsPayouts",
     *      description="talksBookingsPayouts - BookingsPayout",
     *      type="object"
     * )
     *
     * @var BookingsPayout
     */

    public $talksBookingsPayouts;


}
