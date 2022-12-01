<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\ScoreEngineService;
use App\Http\Requests\BlacklistSaveRequest;
use App\Http\Requests\BlacklistDatatableRequest;
use App\Http\Requests\BlacklistToogleActiveRequest;

class BlacklistController extends Controller
{
    public function __construct(protected ScoreEngineService $scoreEngineService)
    {
        $this->scoreEngineService->isApiCall = true;
    }

    /**
     * @OA\Post(
     *      path="/api/blacklists/paginate",
     *      summary="Get paginated list of blacklisted records",
     *      description="Allow to return n records using filters, search, order",
     *      operationId="blacklistsPaginate",
     *      tags={"blacklist"},
     *      @OA\RequestBody(
     *         required=true,
     *         description="Pass pagination data",
     *         @OA\JsonContent(
     *            required={"type"},
     *            @OA\Property(property="type", type="string", enum={"IP","DOMAIN","EMAIL"}, example="DOMAIN"),
     *            @OA\Property(property="page_length", type="integer", example="10"),
     *            @OA\Property(property="page", type="integer", example="1"),
     *            @OA\Property(property="filter", type="string", example="all", default="all"),
     *            @OA\Property(property="search", type="string", example="seznam.cz", default=""),
     *            @OA\Property(property="order_by", type="string", enum={"id","value","reason","active","created_at"}, example="id"),
     *            @OA\Property(property="sort_asc", type="boolean", example="1", default="0"),
     *         ),
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *            @OA\Property(property="BlacklistPaginator", type="object", ref="#/components/schemas/BlacklistPaginator")
     *         )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation errors",
     *          @OA\JsonContent(
     *              @OA\Schema(type="string"),
     *              @OA\Examples(example="string", value="The type field is required.", summary="The type field is required."),
     *          )
     * )
     * )
     */
    public function getPaginated(BlacklistDatatableRequest $request): JsonResponse
    {
        return $this->scoreEngineService->fetchBlacklistDatatable($request->input('type'), (int) $request->input('page_length', 10), (int) $request->input('page', 1), $request->input('filter', 'all'), $request->input('search'), $request->input('order_by', 'id'), (bool) $request->input('sort_asc', true));
    }

    /**
     * @OA\Post(
     *      path="/api/blacklists",
     *      summary="Update or create blacklist record",
     *      description="Save blacklist record",
     *      operationId="blacklistsUpdateOrCreate",
     *      tags={"blacklist"},
     *      @OA\RequestBody(
     *         required=true,
     *         description="Pass blacklist record data",
     *         @OA\JsonContent(
     *              required={"type", "value"},
     *              @OA\Property(property="id", type="integer", example="15", nullable="true", description="Identificator of the blacklist record. If provided, update is performed"),
     *              @OA\Property(property="type", type="string", enum={"IP","DOMAIN","EMAIL"}, example="DOMAIN", description="Blacklist type"),
     *              @OA\Property(property="value", type="string", example="snoopy.", description="The value to be processed against the entity"),
     *              @OA\Property(property="reason", type="string", example="Too many spammers...", description="Note"),
     *              @OA\Property(property="active", type="boolean", default=true, description="If true, current blacklist object will be processed"),
     *         ),
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *            @OA\Property(property="BlacklistResource", type="object", ref="#/components/schemas/BlacklistResource")
     *         )
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *            @OA\Property(property="error", type="string", example="blacklist.type_value_combination_exists"),
     *         )
     *      ),
     * )
     */
    public function updateOrCreate(BlacklistSaveRequest $request): JsonResponse
    {
        return $this->scoreEngineService->updateBlacklistRecord((int) $request->input('id'), $request->input('type'), $request->input('value'), $request->input('reason'), (bool) $request->input('active'));
    }

    /**
     * @OA\Delete(
     *      path="/api/blacklists/{blacklist_id}",
     *      summary="Delete blacklist record",
     *      description="Delete blacklist record",
     *      operationId="blacklistsDestroy",
     *      tags={"blacklist"},
     *      @OA\Parameter(name="blacklist_id", description="ID of the blacklist record", in="path", required=true, example="123", @OA\Schema(type="integer")),
     *      @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *            @OA\Property(property="message",type="string", example="Blacklist has been successfuly deleted")
     *         )
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *            @OA\Property(property="error", type="string", example="Unable to delete blacklist"),
     *         )
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="Blacklist record was not found"),
     *         )
     *      ),
     * )
     */
    public function destroy(Request $request, int $blacklistId): JsonResponse
    {
        return $this->scoreEngineService->deleteBlacklistRecord($blacklistId);
    }

    /**
     * @OA\Post(
     *      path="/api/blacklists/toggle-active",
     *      summary="Toggle active state ",
     *      description="Toggle active state of the blacklist record",
     *      operationId="toggleActive",
     *      tags={"blacklist"},
     *      @OA\RequestBody(
     *         required=true,
     *         description="Pass blacklist record identificator",
     *         @OA\JsonContent(
     *              required={"id"},
     *              @OA\Property(property="id", type="integer", example="15", description="Identificator of the blacklist record"),
     *         ),
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *            @OA\Property(property="BlacklistResource", type="object", ref="#/components/schemas/BlacklistResource")
     *         )
     *      ),
     * )
     */
    public function toggleActive(BlacklistToogleActiveRequest $request): JsonResponse
    {
        return $this->scoreEngineService->toggleBlacklistRecordActive((int) $request->input('id'));
    }
}
