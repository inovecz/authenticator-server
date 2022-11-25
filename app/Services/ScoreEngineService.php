<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class ScoreEngineService
{

    public function __construct(public bool $isApiCall = false)
    {
    }

    public function score(Request $request, array $data): array
    {
        $start = microtime(true);
        $user = User::where('email', $data['email'])->first();
        $data['hash'] = $user->getHash();
        $data['user_agent'] = $request->userAgent();
        $data['ip'] = $request->getClientIp();
        $response = Http::post(config('app.scoring_engine_api').'/score-login', $data);
        $resultArray = array_merge($response->json(), ['duration' => round(microtime(true) - $start, 2)]);

        if ($response->successful()) {
            $user->update([
                'last_attemp_at' => now(),
                'average_score' => ($user->getAverageScore() * $user->getLoginCount() + $resultArray['score']) / ($user->getLoginCount() + 1),
                'login_count' => $user->getLoginCount() + 1,
            ]);
        }

        return $resultArray;
    }

    public function fetchBlacklistCount(): array
    {
        $response = Http::get(config('app.scoring_engine_api').'/blacklists/count');
        if ($response->successful()) {
            return $response->json();
        }
        return ['IP' => 'N/A', 'DOMAIN' => 'N/A', 'EMAIL' => 'N/A'];
    }

    public function fetchBlacklistDatatable(string $type, int $pageLength = 10, int $page = 0, ?string $filter = null, ?string $search = null, ?string $orderBy = null, bool $sortAsc = false): array|false|JsonResponse
    {
        $data = [
            'page_length' => $pageLength ?? 10,
            'page' => $page ?? 0,
            'filter' => $filter ?? 'all',
            'search' => $search,
            'order_by' => $orderBy ?? 'id',
            'sort_asc' => $sortAsc ?? true,
        ];
        $response = Http::post(config('app.scoring_engine_api').'/blacklists/'.$type.'/datatable', $data);
        if ($response->successful()) {
            return $this->isApiCall ? Response::toJsonResponse($response) : $response->json();
        }
        return $this->isApiCall ? Response::toJsonResponse($response) : false;
    }

    public function toggleBlacklistRecordActive(int $blacklistId): array|false|JsonResponse
    {
        $response = Http::get(config('app.scoring_engine_api').'/blacklists/'.$blacklistId.'/toggle-active');
        if ($response->successful()) {
            return $this->isApiCall ? Response::toJsonResponse($response) : $response->json();
        }
        return $this->isApiCall ? Response::toJsonResponse($response) : false;
    }

    public function deleteBlacklistRecord(int $blacklistId): bool|JsonResponse
    {
        $response = Http::post(config('app.scoring_engine_api').'/blacklists', ['_method' => 'delete', 'id' => $blacklistId]);
        return $this->isApiCall ? Response::toJsonResponse($response) : $response->successful();
    }

    public function updateBlacklistRecord(?int $id, string $type, string $value, ?string $reason, bool $active = false): array|false|JsonResponse
    {
        $data = compact('type', 'value', 'reason', 'active');
        if ($id) {
            $data = array_merge(['id' => $id], $data);
        }
        $response = Http::post(config('app.scoring_engine_api').'/blacklists', $data);
        if ($response->successful()) {
            return $this->isApiCall ? Response::toJsonResponse($response) : $response->json();
        }
        return $this->isApiCall ? Response::toJsonResponse($response) : false;
    }

    public function fetchSettings(): array|false
    {
        $response = Http::get(config('app.scoring_engine_api').'/settings');
        if ($response->successful()) {
            return $response->json();
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    public function updateSetting(string $key, mixed $value): bool|JsonResponse
    {
        $response = Http::post(config('app.scoring_engine_api').'/settings', compact('key', 'value'));
        return $this->isApiCall ? Response::toJsonResponse($response) : $response->successful();
    }
}
