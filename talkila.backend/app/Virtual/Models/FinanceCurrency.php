<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="FinanceCurrency",
 *     description="FinanceCurrency - model",
 *     @OA\Xml(
 *         name="FinanceCurrency"
 *     )
 * )
 */

class FinanceCurrency
{
// Swagger Deffinition

     /**
     * @OA\Property(
     *      title="id",
     *      description="id - int",
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
     *      title="iso_code",
     *      description="iso_code - string",
     *      example="Lorem ipsum dolor",
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
     *      example="Lorem ipsum dolor",
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
     *      example="Lorem ipsum dolor",
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
     *      example="Lorem ipsum dolor",
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
     *      example="Lorem ipsum dolor",
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
     *      title="financeCurrenciesPayouts",
     *      description="financeCurrenciesPayouts - Payout",
     *      type="object"
     * )
     *
     * @var \App\Virtual\Models\Payout
     */

    public $financeCurrenciesPayouts;


}
