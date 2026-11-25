<?php
namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="GenericSuccess",
 *     description="GenericSuccess - model",
 *     @OA\Xml(
 *         name="GenericSuccess "
 *     )
 * )
 */

class GenericSuccess {

    /**
     * @OA\Property(
     *      title="message",
     *      description="message",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $message;

    /**
     * @OA\Property(
     *      title="success",
     *      description="success",
     *      example="Lorem ipsum dolor",
     *      type="string"
     * )
     *
     * @var string
     */

    public $success;
}
