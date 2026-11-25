<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="StoreStaticMetricRequest",
 *     description="StoreStaticMetricRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class StoreStaticMetricRequest
{
// Swagger Deffinition



    public $id;


    /**
     * @OA\Property(
     *      title="follower",
     *      description="follower - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $follower;


    /**
     * @OA\Property(
     *      title="reviews",
     *      description="reviews - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $reviews;


    /**
     * @OA\Property(
     *      title="calls",
     *      description="calls - smallint",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="smallint"
     * )
     *
     * @var smallint
     */

    public $calls;


    /**
     * @OA\Property(
     *      title="revenue",
     *      description="revenue - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $revenue;


    /**
     * @OA\Property(
     *      title="bad_reports",
     *      description="bad_reports - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $bad_reports;


    /**
     * @OA\Property(
     *      title="send_emails",
     *      description="send_emails - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $send_emails;


    /**
     * @OA\Property(
     *      title="searches_per_day",
     *      description="searches_per_day - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $searches_per_day;


    /**
     * @OA\Property(
     *      title="visited_user_profils_per_day",
     *      description="visited_user_profils_per_day - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $visited_user_profils_per_day;


    /**
     * @OA\Property(
     *      title="dont_show_again",
     *      description="dont_show_again - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $dont_show_again;


    /**
     * @OA\Property(
     *      title="visited",
     *      description="visited - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $visited;


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
