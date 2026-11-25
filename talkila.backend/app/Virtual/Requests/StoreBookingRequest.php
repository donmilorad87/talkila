<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="StoreBookingRequest",
 *     description="StoreBookingRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class StoreBookingRequest
{
// Swagger Deffinition



    /**
     * @OA\Property(
     *      title="state",
     *      description="state - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $state;


    /**
     * @OA\Property(
     *      title="extension",
     *      description="extension - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $extension;


    /**
     * @OA\Property(
     *      title="anonym",
     *      description="anonym - integer",
     *      example=1,
     *      format="int64",
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
     *      example="2020-01-27 17:50:45",
     *      format="string",
     *      type="datetime"
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
     *      format="string",
     *      type="datetime"
     * )
     *
     * @var \DateTime
     */

    public $end_call;


    /**
     * @OA\Property(
     *      title="duration",
     *      description="duration - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $duration;

    /**
     * @OA\Property(
     *      title="price",
     *      description="price - number",
     *      example=66.99,
     *      format="float",
     *      type="number"
     * )
     *
     * @var decimal
     */

    public $price;


    /**
     * @OA\Property(
     *      title="message",
     *      description="message - text",
     *      example="Lorem Ipsum",
     *      format="string",
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
     *      format="string",
     *      type="datetime"
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
     *      format="string",
     *      type="datetime"
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
     *      format="string",
     *      type="datetime"
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
     *      description="finance_currencies_id - integer",
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




}
