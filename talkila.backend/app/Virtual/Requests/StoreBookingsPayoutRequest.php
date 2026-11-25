<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="StoreBookingsPayoutRequest",
 *     description="StoreBookingsPayoutRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class StoreBookingsPayoutRequest
{
// Swagger Deffinition



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


    /**
     * @OA\Property(
     *      title="payouts_id",
     *      description="payouts_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $payouts_id;


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
