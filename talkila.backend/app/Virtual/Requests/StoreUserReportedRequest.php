<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="StoreUserReportedRequest",
 *     description="StoreUserReportedRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class StoreUserReportedRequest
{
// Swagger Deffinition



    public $id;


    /**
     * @OA\Property(
     *      title="description",
     *      description="description - text",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $description;


    /**
     * @OA\Property(
     *      title="type_id",
     *      description="type_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $type_id;


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


    /**
     * @OA\Property(
     *      title="reporter_user_id",
     *      description="reporter_user_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $reporter_user_id;




}
