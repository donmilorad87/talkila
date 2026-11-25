<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="Talk",
 *     description="Talk - model",
 *     @OA\Xml(
 *         name="Talk"
 *     )
 * )
 */
class Talk
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
     *      title="anonym_call",
     *      description="anonym_call - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $anonym_call;


    /**
     * @OA\Property(
     *      title="call_type",
     *      description="call_type - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $call_type;


    /**
     * @OA\Property(
     *      title="talk_type",
     *      description="talk_type - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $talk_type;


    /**
     * @OA\Property(
     *      title="headline",
     *      description="headline - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $headline;


    /**
     * @OA\Property(
     *      title="description",
     *      description="description - text",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $description;


    /**
     * @OA\Property(
     *      title="duration",
     *      description="duration - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $duration;


    /**
     * @OA\Property(
     *      title="price",
     *      description="price - decimal",
     *      example=66.99,
     *      format="float",
     *      type="number"
     * )
     *
     * @var number
     */

    public $price;


    /**
     * @OA\Property(
     *      title="max_participiants",
     *      description="max_participiants - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $max_participiants;


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
     *      title="teacher_user_id",
     *      description="teacher_user_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $teacher_user_id;


    /**
     * @OA\Property(
     *      title="languages_id",
     *      description="languages_id - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $languages_id;


    /**
     * @OA\Property(
     *      title="finance_currencies_id",
     *      description="finance_currencies_id - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $finance_currencies_id;


    /**
     * @OA\Property(
     *      title="billing_address_id",
     *      description="billing_address_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $billing_address_id;


    /**
     * @OA\Property(
     *      title="talk_categories_id",
     *      description="talk_categories_id - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $talk_categories_id;


    /**
     * @OA\Property(
     *      title="talk_subcategories_id",
     *      description="talk_subcategories_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $talk_subcategories_id;


    /**
     * @OA\Property(
     *      title="state",
     *      description="state - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $state;


    /**
     * @OA\Property(
     *      title="talk_bookings",
     *      description="talk_bookings - TalksBooking",
     *      type="object"
     * )
     *
     * @var TalksBooking
     */

    public $talk_bookings;


}
