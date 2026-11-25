<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Payout",
 *     description="Payout - model",
 *     @OA\Xml(
 *         name="Payout"
 *     )
 * )
 */

class Payout
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
     *      format="datetime",
     *      type="string"
     * )
     *
     * @var \DateTime
     */

    public $payout_date;


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
     *      title="invoice_number",
     *      description="invoice_number - string",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $invoice_number;


     /**
     * @OA\Property(
     *      title="sales_tax",
     *      description="sales_tax - int",
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
     *      example="Lorem ipsum dolor",
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
     *      format="datetime",
     *      type="string"
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
     *      title="payoutsBookingsPayouts",
     *      description="payoutsBookingsPayouts - BookingsPayout",
     *      type="object"
     * )
     *
     * @var \App\Virtual\Models\BookingsPayout
     */

    public $payoutsBookingsPayouts;


}
