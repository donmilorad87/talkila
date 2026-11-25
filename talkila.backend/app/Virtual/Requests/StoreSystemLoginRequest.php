<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="StoreSystemLoginRequest",
 *     description="StoreSystemLoginRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class StoreSystemLoginRequest
{
// Swagger Deffinition



    public $id;


    /**
     * @OA\Property(
     *      title="login_type",
     *      description="login_type - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $login_type;


    /**
     * @OA\Property(
     *      title="type",
     *      description="type - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $type;


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
