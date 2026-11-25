<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="AuditLog",
 *     description="AuditLog model",
 *     @OA\Xml(
 *         name="AuditLog"
 *     )
 * )
 */
class AuditLog
{
    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description",
     *      example="This is new description"
     * )
     *
     * @var string
     */
    public $description;
    /**
     * @OA\Property(
     *      title="Subject ID",
     *      description="Subject Id",
     *      format="int64",
     *      example=1,
     * )
     *
     * @var integer
     */
    public $subject_id;
    /**
     * @OA\Property(
     *      title="Subject Type",
     *      description="Subject Type",
     *      example="This is new Subject Type"
     * )
     *
     * @var string
     */
    public $subject_type;
    /**
     * @OA\Property(
     *      title="User ID",
     *      description="User Id",
     *      format="int64",
     *      example=1,
     * )
     *
     * @var integer
     */
    public $user_id;
    /**
     * @OA\Property(
     *      title="Host",
     *      description="Host",
     *      example="127.0.0.1"
     * )
     *
     * @var string
     */
    public $host;
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;
    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;
}
