<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="EmailHistoriesLog",
 *     description="EmailHistoriesLog - model",
 *     @OA\Xml(
 *         name="EmailHistoriesLog"
 *     )
 * )
 */

class EmailHistoriesLog
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
     *      title="from_user",
     *      description="from_user - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $from_user;


     /**
     * @OA\Property(
     *      title="to_user",
     *      description="to_user - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $to_user;


     /**
     * @OA\Property(
     *      title="subject",
     *      description="subject - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $subject;


     /**
     * @OA\Property(
     *      title="message",
     *      description="message - text",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $message;


     /**
     * @OA\Property(
     *      title="template_id",
     *      description="template_id - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $template_id;


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
     *      title="user",
     *      description="user - User",
     *      type="object"
     * )
     *
     * @var \App\Virtual\Models\User
     */

    public $user;


}
