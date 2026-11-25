<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="StoreFinanceCurrencyRequest",
 *     description="StoreFinanceCurrencyRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class StoreFinanceCurrencyRequest
{
// Swagger Deffinition



    public $id;


    /**
     * @OA\Property(
     *      title="iso_code",
     *      description="iso_code - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $iso_code;


    /**
     * @OA\Property(
     *      title="short_code",
     *      description="short_code - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $short_code;


    /**
     * @OA\Property(
     *      title="name",
     *      description="name - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $name;


    /**
     * @OA\Property(
     *      title="value",
     *      description="value - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $value;


    /**
     * @OA\Property(
     *      title="symbol",
     *      description="symbol - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $symbol;


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
