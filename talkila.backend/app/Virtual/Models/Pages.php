<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="Pages",
 *     description="Pages - model",
 *     @OA\Xml(
 *         name="Pages"
 *     )
 * )
 */
class Pages
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
     *      title="slug",
     *      description="slug - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $slug;


    /**
     * @OA\Property(
     *      title="bg_img",
     *      description="bg_img - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $bg_img;


    /**
     * @OA\Property(
     *      title="show_contact",
     *      description="show_contact - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $show_contact;


    /**
     * @OA\Property(
     *      title="body",
     *      description="body - text",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $body;


    /**
     * @OA\Property(
     *      title="meta_data",
     *      description="meta_data - text",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $meta_data;


    /**
     * @OA\Property(
     *      title="template",
     *      description="template - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $template;


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
