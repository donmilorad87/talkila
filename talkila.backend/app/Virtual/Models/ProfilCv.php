<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="ProfilCv",
 *     description="ProfilCv - model",
 *     @OA\Xml(
 *         name="ProfilCv"
 *     )
 * )
 */
class ProfilCv
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
     *      title="type",
     *      description="type - int",
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
     *      title="start_date",
     *      description="start_date - date",
     *      example="",
     *      format="",
     *      type="date"
     * )
     *
     * @var date
     */

    public $start_date;


    /**
     * @OA\Property(
     *      title="end_date",
     *      description="end_date - date",
     *      example="",
     *      format="",
     *      type="date"
     * )
     *
     * @var date
     */

    public $end_date;


    /**
     * @OA\Property(
     *      title="company_name",
     *      description="company_name - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $company_name;


    /**
     * @OA\Property(
     *      title="profession",
     *      description="profession - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $profession;


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
     *      title="profession_id",
     *      description="profession_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $profession_id;


    /**
     * @OA\Property(
     *      title="location",
     *      description="location - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $location;


    /**
     * @OA\Property(
     *      title="work_here",
     *      description="work_here - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $work_here;


    /**
     * @OA\Property(
     *      title="user",
     *      description="user - User",
     *      type="object"
     * )
     *
     * @var User
     */

    public $user;


}
