<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="LanguagesProfil",
 *     description="LanguagesProfil - model",
 *     @OA\Xml(
 *         name="LanguagesProfil"
 *     )
 * )
 */

class LanguagesProfil
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
     *      title="level",
     *      description="level - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $level;


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
     *      title="language_id",
     *      description="language_id - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $language_id;


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
