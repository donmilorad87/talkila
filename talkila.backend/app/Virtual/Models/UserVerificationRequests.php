<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="UserVerificationRequests",
 *     description="UserVerificationRequests - model",
 *     @OA\Xml(
 *         name="UserVerificationRequests"
 *     )
 * )
 */

class UserVerificationRequests
{
// Swagger Deffinition

     /**
     * @OA\Property(
     *      title="id",
     *      description="id - bigint",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var bigint
     */

    public $id;


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
     *      title="name",
     *      description="name - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $name;


     /**
     * @OA\Property(
     *      title="image",
     *      description="image - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $image;


     /**
     * @OA\Property(
     *      title="request_date",
     *      description="request_date - datetime",
     *      example="2020-01-27 17:50:45",
     *      format="datetime",
     *      type="string"
     * )
     *
     * @var \DateTime
     */

    public $request_date;


     /**
     * @OA\Property(
     *      title="approve_date",
     *      description="approve_date - datetime",
     *      example="2020-01-27 17:50:45",
     *      format="datetime",
     *      type="string"
     * )
     *
     * @var \DateTime
     */

    public $approve_date;


     /**
     * @OA\Property(
     *      title="status",
     *      description="status - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $status;


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
     *      title="user",
     *      description="user - User",
     *      type="object"
     * )
     *
     * @var \App\Virtual\Models\User
     */

    public $user;


}
