<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="StoreNotificationsRequest",
 *     description="StoreNotificationsRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */

class StoreNotificationsRequest
{
// Swagger Deffinition




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


    /**
     * @OA\Property(
     *      title="type",
     *      description="type - string",
     *      example="Lorem Ipsum",
     *      type="string"
     * )
     *
     * @var string
     */

    public $type;


    /**
     * @OA\Property(
     *      title="values",
     *      description="values - text",
     *      example="Lorem Ipsum",
     *      type="string"
     * )
     *
     * @var string
     */

    public $values;


    /**
     * @OA\Property(
     *      title="pushed_at",
     *      description="pushed_at - datetime",
     *      example="2020-01-27 17:50:45",
     *      format="datetime",
     *      type="string"
     * )
     *
     * @var \DateTime
     */

    public $pushed_at;


    /**
     * @OA\Property(
     *      title="state",
     *      description="state - int",
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


}
