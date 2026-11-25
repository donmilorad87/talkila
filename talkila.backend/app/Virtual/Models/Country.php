<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="Country",
 *     description="Country - model",
 *     @OA\Xml(
 *         name="Country"
 *     )
 * )
 */
class Country
{
// Swagger Deffinition

    /**
     * @OA\Property(
     *      title="id",
     *      description="id - int",
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
     *      title="short_code",
     *      description="short_code - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $short_code;


    /**
     * @OA\Property(
     *      title="english",
     *      description="english - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $english;


    /**
     * @OA\Property(
     *      title="german",
     *      description="german - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $german;


    /**
     * @OA\Property(
     *      title="croatian",
     *      description="croatian - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $croatian;


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
     *      title="shorter_code",
     *      description="shorter_code - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $shorter_code;


    /**
     * @OA\Property(
     *      title="spanish",
     *      description="spanish - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $spanish;


    /**
     * @OA\Property(
     *      title="french",
     *      description="french - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $french;


    /**
     * @OA\Property(
     *      title="italian",
     *      description="italian - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $italian;


    /**
     * @OA\Property(
     *      title="dutch",
     *      description="dutch - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $dutch;


    /**
     * @OA\Property(
     *      title="polish",
     *      description="polish - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $polish;


    /**
     * @OA\Property(
     *      title="danish",
     *      description="danish - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $danish;


    /**
     * @OA\Property(
     *      title="hungarian",
     *      description="hungarian - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $hungarian;


    /**
     * @OA\Property(
     *      title="portuguese",
     *      description="portuguese - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $portuguese;


    /**
     * @OA\Property(
     *      title="russian",
     *      description="russian - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $russian;


    /**
     * @OA\Property(
     *      title="turkish",
     *      description="turkish - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $turkish;


    /**
     * @OA\Property(
     *      title="bulgarian",
     *      description="bulgarian - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $bulgarian;


    /**
     * @OA\Property(
     *      title="romanian",
     *      description="romanian - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $romanian;


    /**
     * @OA\Property(
     *      title="slovak",
     *      description="slovak - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $slovak;


    /**
     * @OA\Property(
     *      title="czech",
     *      description="czech - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $czech;


}
