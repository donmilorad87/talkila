<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="UpdatePayoutRequest",
 *     description="UpdatePayoutRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class UpdatePayoutRequest
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
     *      title="payout_date",
     *      description="payout_date - datetime",
     *      example="2020-01-27 17:50:45",
     *      format="string",
     *      type="datetime"
     * )
     *
     * @var \DateTime
     */

    public $payout_date;


    /**
     * @OA\Property(
     *      title="price",
     *      description="price - number",
     *      example=66.99,
     *      format="float",
     *      type="number"
     * )
     *
     * @var decimal
     */

    public $price;


    /**
     * @OA\Property(
     *      title="invoice_number",
     *      description="invoice_number - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $invoice_number;


    /**
     * @OA\Property(
     *      title="sales_tax",
     *      description="sales_tax - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $sales_tax;


    /**
     * @OA\Property(
     *      title="reference",
     *      description="reference - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $reference;


    /**
     * @OA\Property(
     *      title="transferred_date",
     *      description="transferred_date - datetime",
     *      example="2020-01-27 17:50:45",
     *      format="string",
     *      type="datetime"
     * )
     *
     * @var \DateTime
     */

    public $transferred_date;


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
     *      title="finance_currencies_id",
     *      description="finance_currencies_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $finance_currencies_id;


}
