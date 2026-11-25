<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="Permission",
 *     description="Permission - model",
 *     @OA\Xml(
 *         name="Permission"
 *     )
 * )
 */
class Permission
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
     *      title="title",
     *      description="title - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $title;


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
