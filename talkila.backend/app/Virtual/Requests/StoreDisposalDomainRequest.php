<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="StoreDisposalDomainRequest",
 *     description="StoreDisposalDomainRequest - Request body data",
 *     type="object",
 *     required={""}
 * )
 */
class StoreDisposalDomainRequest
{
// Swagger Deffinition



    public $id;


    /**
     * @OA\Property(
     *      title="domain",
     *      description="domain - string",
     *      example="Lorem Ipsum",
     *      format="string",
     *      type="string"
     * )
     *
     * @var string
     */

    public $domain;


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
