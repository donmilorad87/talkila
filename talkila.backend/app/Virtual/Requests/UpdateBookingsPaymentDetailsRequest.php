<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="UpdateBookingsPaymentDetailsRequest",
 *     description="UpdateBookingsPaymentDetailsRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */

class UpdateBookingsPaymentDetailsRequest
{
// Swagger Deffinition

    /**
     * @OA\Property(
     *      title="booking_id",
     *      description="booking_id - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $booking_id;



    /**
     * @OA\Property(
     *      title="status",
     *      description="status - int",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $status;


    /**
     * @OA\Property(
     *      title="payment_reference",
     *      description="payment_reference - text",
     *      example="Lorem Ipsum",
     *      type="string"
     * )
     *
     * @var string
     */

    public $payment_reference;


    /**
     * @OA\Property(
     *      title="amount_value",
     *      description="amount_value - decimal",
     *      example=66.99,
     *      format="float",
     *      type="number"
     * )
     *
     * @var number
     */

    public $amount_value;


    /**
     * @OA\Property(
     *      title="amount_currency",
     *      description="amount_currency - text",
     *      example="Lorem Ipsum",
     *      type="string"
     * )
     *
     * @var string
     */

    public $amount_currency;



    /**
     * @OA\Property(
     *      title="creation_date",
     *      description="created_at - datetime",
     *      example="2020-01-27 17:50:45",
     *      format="datetime",
     *      type="string"
     * )
     *
     * @var \DateTime
     */

    public $creation_date;

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


}
