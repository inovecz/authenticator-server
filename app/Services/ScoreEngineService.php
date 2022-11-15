<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ScoreEngineService
{
    public function score(Request $request, array $data): array
    {
        $start = microtime(true);
        $user = User::where('email', $data['email'])->first();
        $data['hash'] = $user->getHash();
        unset($data['email']);
        $data['user-agent'] = $request->userAgent();
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

    public function fetchBlacklistDatatable(string $type, int $pageLength = 10, int $page = 0, string $filter = 'all', string $search = '', string $orderBy = 'id', bool $sortAsc = false): array
    {
        $data = compact('pageLength', 'page', 'filter', 'search', 'orderBy', 'sortAsc');
        $response = Http::post(config('app.scoring_engine_api').'/blacklists/'.$type.'/datatable', $data);
        if ($response->successful()) {
            return $response->json();
        }
        return [];
    }

    public function toggleBlacklistRecordActive(int $blacklistId): array
    {
        $response = Http::get(config('app.scoring_engine_api').'/blacklists/'.$blacklistId.'/toggle-active');
        if ($response->successful()) {
            return $response->json();
        }
        return [];
    }

    public function deleteBlacklistRecord(int $blacklistId): bool
    {
        $response = Http::post(config('app.scoring_engine_api').'/blacklists', ['_method' => 'delete', 'id' => $blacklistId]);
        if ($response->successful()) {
            return true;
        }
        return false;
    }

    public function updateBlacklistRecord(int $id, string $type, string $value, ?string $reason, bool $active): array
    {
        $response = Http::post(config('app.scoring_engine_api').'/blacklists', compact('id', 'type', 'value', 'reason', 'active'));
        if ($response->successful()) {
            return $response->json();
        }
        return [];
    }
}
