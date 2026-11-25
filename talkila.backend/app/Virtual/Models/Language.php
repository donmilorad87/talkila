<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="Language",
 *     description="Language - model",
 *     @OA\Xml(
 *         name="Language"
 *     )
 * )
 */
class Language
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
     *      title="code",
     *      description="code - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $code;


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
     *      title="languageLanguagesProfils",
     *      description="languageLanguagesProfils - LanguagesProfil",
     *      type="object"
     * )
     *
     * @var LanguagesProfil
     */

    public $languageLanguagesProfils;


}
