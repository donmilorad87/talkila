<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="UpdateAvailabilityRequest",
 *     description="UpdateAvailabilityRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class UpdateAvailabilityRequest
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
     *      title="weekday",
     *      description="weekday - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $weekday;


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
     *      title="start_time",
     *      description="start_time - time",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="time"
     * )
     *
     * @var time
     */

    public $start_time;


    /**
     * @OA\Property(
     *      title="end_time",
     *      description="end_time - time",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="time"
     * )
     *
     * @var time
     */

    public $end_time;


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
     *      title="user_id",
     *      description="user_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $user_id;


}
