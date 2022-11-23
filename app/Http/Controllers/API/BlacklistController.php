<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\ScoreEngineService;
use App\Http\Requests\BlacklistDatatableRequest;

class BlacklistController extends Controller
{
    public function __construct(protected ScoreEngineService $scoreEngineService)
    {
    }

    //public function getAll(): AnonymousResourceCollection
    //{
    //    //
    //}

//    public function getCount(): JsonResponse
//    {
//
//    }
//
//    public function getByType(Request $request): AnonymousResourceCollection
//    {
//
//    }
//
    public function getDatatable(BlacklistDatatableRequest $request): JsonResponse
    {
        $fetched = $this->scoreEngineService->fetchBlacklistDatatable($request->input('type'), $request->input('pageLength'), $request->input('page'), $request->input('filter'), $request->input('search'), $request->input('orderBy'), $request->input('sortAsc'));
        return $fetched ? $this->success($fetched) : $this->error('Not able to fetch blacklists');
    }
//
//    public function updateOrCreate(BlacklistSaveRequest $request): JsonResponse|BlacklistResource
//    {
//
//    }
//
//    public function destroy(BlacklistDeleteRequest $request): JsonResponse
//    {
//
//    }
//
//    public function toggleActive(Request $request, Blacklist $blacklist): BlacklistResource
//    {
//
//    }
}
