<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="BillingAddress",
 *     description="BillingAddress model",
 *     @OA\Xml(
 *         name="BillingAddress"
 *     )
 * )
 */
class BillingAddress
{
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
     *      title="Street",
     *      description="Street / Address",
     *      example="street"
     * )
     *
     * @var string
     */
    public $street;


    /**
     * @OA\Property(
     *      title="Zip code",
     *      description="zip code / postal code",
     *      example="zipcode"
     * )
     *
     * @var string
     */
    public $zipcode;


    /**
     * @OA\Property(
     *      title="City",
     *      description="city",
     *      example="city"
     * )
     *
     * @var string
     */
    public $city;


    /**
     * @OA\Property(
     *      title="Company name",
     *      description="company_name",
     *      example="company_name"
     * )
     *
     * @var string
     */
    public $company_name;


    /**
     * @OA\Property(
     *      title="Tax NUM",
     *      description="tax number",
     *      example="HR00000000001"
     * )
     *
     * @var string
     */
    public $tax_number;


    /**
     * @OA\Property(
     *      title="Email",
     *      description="Email",
     *      example="email@email.com"
     * )
     *
     * @var string
     */
    public $email;


    /**
     * @OA\Property(
     *      title="Tel Number",
     *      description="Phone / Tel Number",
     *      example="+555555"
     * )
     *
     * @var string
     */
    public $tel_number;


    /**
     * @OA\Property(
     *      title="Vat Number",
     *      description="Vat",
     *      example="VA1234566"
     * )
     *
     * @var string
     */
    public $vat;


    /**
     * @OA\Property(
     *      title="Country ID",
     *      description="Country Id",
     *      format="int64",
     *      example=1,
     * )
     *
     * @var integer
     */

    public $countries_id;


    /**
     * @OA\Property(
     *     title="Country",
     *     description="Country model"
     * )
     *
     * @var \App\Virtual\Models\Country
     */
    public $countries;


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

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $deleted_at;

}
