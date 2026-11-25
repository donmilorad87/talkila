<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\ModelsApi\DisposalEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDisposalEmailRequest;
use App\Http\Requests\UpdateDisposalEmailRequest;
use App\Http\Resources\Admin\DisposalEmailResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @OA\Tag(
 *     name="DisposalEmails",
 *     description="Everything about DisposalEmails",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/disposal-emails",
 *      operationId="index",
 *      tags={"DisposalEmails"},
 *      summary="Get list of DisposalEmails",
 *      description="Returns list of DisposalEmails",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/DisposalEmailResource")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns list of DisposalEmails
 */

/**
 * @OA\Post(
 *      path="/v1/disposal-emails",
 *      operationId="store",
 *      tags={"DisposalEmails"},
 *      summary="Get requested fields from form and create new DisposalEmail",
 *      description="Get requested fields from form and create new DisposalEmail",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/StoreDisposalEmailRequest")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/DisposalEmail")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 */

/**
 * @OA\Get(
 *      path="/v1/disposal-emails/{disposal_email}",
 *      operationId="show",
 *      tags={"DisposalEmails"},
 *      summary="Get DisposalEmails information",
 *      description="Returns DisposalEmails data",
 *      @OA\Parameter(
 *          name="disposal_email",
 *          description="DisposalEmail id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/DisposalEmail")
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */

/**
 * @OA\Put(
 *      path="/v1/disposal-emails/{disposal_email}",
 *      operationId="update",
 *      tags={"DisposalEmails"},
 *      summary="Get DisposalEmails update information",
 *      description="Get requested fields from form and update requested DisposalEmail",
 *      @OA\Parameter(
 *          name="disposal_email",
 *          description="DisposalEmail id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/UpdateDisposalEmailRequest")
 *      ),
 *      @OA\Response(
 *          response=202,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/DisposalEmail")
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */

/**
 * @OA\Delete(
 *      path="/v1/disposal-emails/{disposal_email}",
 *      operationId="destroy",
 *      tags={"DisposalEmail"},
 *      summary="Delete DisposalEmail",
 *      description="Take requested DisposalEmail and delete it from system",
 *      @OA\Parameter(
 *          name="disposal_email",
 *          description="DisposalEmail id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */
/**
 * Class DisposalEmailsApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class DisposalEmailsApiController extends Controller
{
    /**
     * @return DisposalEmailResource
     */
    public function index()
    {
        abort_if(Gate::denies('disposal_email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DisposalEmailResource(DisposalEmail::all());
    }

    /**
     * @param StoreDisposalEmailRequest $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(StoreDisposalEmailRequest $request)
    {
        $disposalEmail = DisposalEmail::create($request->all());

        return (new DisposalEmailResource($disposalEmail))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param DisposalEmail $disposalEmail
     * @return DisposalEmailResource
     */
    public function show(DisposalEmail $disposalEmail)
    {
        abort_if(Gate::denies('disposal_email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DisposalEmailResource($disposalEmail);
    }

    /**
     * @param UpdateDisposalEmailRequest $request
     * @param DisposalEmail $disposalEmail
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(UpdateDisposalEmailRequest $request, DisposalEmail $disposalEmail)
    {
        $disposalEmail->update($request->all());

        return (new DisposalEmailResource($disposalEmail))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @param DisposalEmail $disposalEmail
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(DisposalEmail $disposalEmail)
    {
        abort_if(Gate::denies('disposal_email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $disposalEmail->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
