<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Schema(
 *      @OA\Xml(name="BlacklistPaginator"),
 *      @OA\Property(property="pageLength", type="integer", example=10, description="Max received items per request"),
 *      @OA\Property(property="page", type="integer", example=1, description="Paging of the received objects"),
 *      @OA\Property(property="total", type="integer", example=18, description="Count of received objects including filter and search"),
 *      @OA\Property(property="filter", type="string", enum={"all", "value", "reason"}, example="all", default="all", description="Filter to search in"),
 *      @OA\Property(property="search", type="string", example="net", default=null, nullable="true", description="Searched string"),
 *      @OA\Property(property="orderBy", type="string", enum={"id","value","reason","active","created_at"}, example="id", description="Object's property to order by"),
 *      @OA\Property(property="sortAsc", type="boolean", example=true, default=false, description="Toggle if order should be ascending (true) or descending (false)"),
 *      @OA\Property(property="data", type="array", description="Array of received objects",
 *          example={
 *              {"id": 4, "type": "DOMAIN", "value": "fraud.net", "reason": "Known fraud domain.", "active": false, "created_at": "2022-11-09T08:34:42"},
 *              {"id": 21,"type": "DOMAIN","value": "capkova.net","reason": null,"active": false,"created_at": "2022-11-12T13:24:39"},
 *              {"id": "...", "type": "...", "value": "...", "reason": "...", "active":"...", "created_at": "..."}
 *          },
 *          @OA\Items(ref="#/components/schemas/BlacklistResource")
 *      ),
 *      @OA\Property(property="next_page", type="integer", description="Number of the next page, if exists. If current page is last, value is null", example=2, nullable="true"),
 *      @OA\Property(property="prev_page", type="integer", description="Number of the previous page, if exists. If current page is first, value is null", example=null, nullable="true"),
 * )
 *
 * Class BlacklistPaginator
 *
 */
class BlacklistPaginator
{
}
