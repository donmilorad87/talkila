<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="StoreBillingAddressRequest",
 *     description="StoreBillingAddressRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class StoreBillingAddressRequest
{
// Swagger Deffinition


    /**
     * @OA\Property(
     *      title="street",
     *      description="street - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $street;


    /**
     * @OA\Property(
     *      title="zipcode",
     *      description="zipcode - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $zipcode;


    /**
     * @OA\Property(
     *      title="city",
     *      description="city - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $city;


    /**
     * @OA\Property(
     *      title="company_name",
     *      description="company_name - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $company_name;


    /**
     * @OA\Property(
     *      title="tax_number",
     *      description="tax_number - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $tax_number;


    /**
     * @OA\Property(
     *      title="email",
     *      description="email - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $email;


    /**
     * @OA\Property(
     *      title="tel_number",
     *      description="tel_number - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $tel_number;


    /**
     * @OA\Property(
     *      title="vat",
     *      description="vat - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $vat;


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
     *      title="state",
     *      description="state - integer",
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
     *      title="countries_id",
     *      description="countries_id - integer",
     *      example=1,
     *      format="int64",
     *      type="integer"
     * )
     *
     * @var integer
     */

    public $countries_id;




}
