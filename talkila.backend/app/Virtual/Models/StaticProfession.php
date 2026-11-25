<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="StaticProfession",
 *     description="StaticProfession - model",
 *     @OA\Xml(
 *         name="StaticProfession"
 *     )
 * )
 */

class StaticProfession
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
     *      title="italien",
     *      description="italien - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $italien;


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
     *      title="professionProfilCvs",
     *      description="professionProfilCvs - ProfilCv",
     *      example="",
     *      format="",
     *      type="ProfilCv"
     * )
     *
     * @var \App\Virtual\Models\ProfilCv
     */

    public $professionProfilCvs;


}
