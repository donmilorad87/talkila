<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="UserBookmarkedTalks",
 *     description="UserBookmarkedTalks - model",
 *     @OA\Xml(
 *         name="UserBookmarkedTalks"
 *     )
 * )
 */

class UserBookmarkedTalks
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
     *      title="talks_id",
     *      description="talks_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $talks_id;


}
