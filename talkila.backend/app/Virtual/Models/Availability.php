<?php

namespace App\Virtual\Models;

use DateTime;
use Time;

/**
 * @OA\Schema(
 *     title="Availability",
 *     description="Availability model",
 *     @OA\Xml(
 *         name="Availability"
 *     )
 * )
 */
class Availability
{

    /**
     * @OA\Property(
     *      title="User ID",
     *      description="User Id",
     *      format="int64",
     *      example=1,
     * )
     *
     * @var integer
     */
    public $user_id;
    /**
     * @OA\Property(
     *      title="Weekday",
     *      description="Weekday",
     *      format="int64",
     *      example=1,
     * )
     *
     * @var integer
     */

    public $weekday;
    /**
     * @OA\Property(
     *      title="State",
     *      description="State",
     *      format="int64",
     *      example=1,
     * )
     *
     * @var integer
     */

    public $state;
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
    /**
     * @OA\Property(
     *     title="User",
     *     description="User model"
     * )
     *
     * @var User
     */
    private $user;
    /**
     * @OA\Property(
     *     title="Start time",
     *     description="Start time",
     *     example="17:50:45",
     *     format="time",
     *     type="string"
     * )
     *
     * @var Time
     */
    private $start_time;

    /**
     * @OA\Property(
     *     title="End time",
     *     description="End time",
     *     example="17:50:45",
     *     format="time",
     *     type="string"
     * )
     *
     * @var Time
     */
    private $end_time;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $deleted_at;

}
