<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="StoreStaticBlockedUserRequest",
 *     description="StoreStaticBlockedUserRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class StoreStaticBlockedUserRequest
{
// Swagger Deffinition



    public $id;


    /**
     * @OA\Property(
     *      title="email",
     *      description="email - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $email;


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


}
