<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="StoreTalksSubcategoriesRequest",
 *     description="StoreTalksSubcategoriesRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class StoreTalksSubcategoriesRequest
{
// Swagger Deffinition



    public $id;


    /**
     * @OA\Property(
     *      title="croatian",
     *      description="croatian - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $croatian;


    /**
     * @OA\Property(
     *      title="german",
     *      description="german - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $german;


    /**
     * @OA\Property(
     *      title="english",
     *      description="english - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $english;


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
     *      title="talk_categories_id",
     *      description="talk_categories_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $talk_categories_id;


}
