<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="StoreEmailHistoriesLogRequest",
 *     description="StoreEmailHistoriesLogRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class StoreEmailHistoriesLogRequest
{
// Swagger Deffinition



    public $id;


    /**
     * @OA\Property(
     *      title="from_user",
     *      description="from_user - string",
     *      example="Lorem Ipsum",
     *      format="string",
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
     *      example="Lorem Ipsum",
     *      format="string",
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
     *      example="Lorem Ipsum",
     *      format="string",
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
     *      example="Lorem Ipsum",
     *      format="string",
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
     *      example="Lorem Ipsum",
     *      format="string",
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



}
