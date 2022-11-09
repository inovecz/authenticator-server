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
        $user =  User::where('email', $data['email'])->first();
        $data['hash'] = $user->getHash();
        unset($data['email']);
        $data['user-agent'] = $request->userAgent();
        $data['ip'] = $request->getClientIp();
        $response = Http::post(config('app.scoring_engine_api') . '/score-login', $data);
        $resultArray = array_merge($response->json(), ['duration' => round(microtime(true) - $start,2)]);

        if ($response->successful()) {
            $user->update([
                'last_attemp_at' => now(),
                'average_score' => ($user->getAverageScore() * $user->getLoginCount() + $resultArray['score']) / ($user->getLoginCount() + 1),
                'login_count' => $user->getLoginCount() + 1,
            ]);
        }

        return $resultArray;
    }

    public function getBlacklistCount(): array
    {
        $response = Http::get(config('app.scoring_engine_api') . '/blacklists/count');
        if ($response->successful()) {
            return $response->json();
        }
        return ['IP' => 'N/A', 'DOMAIN' => 'N/A', 'EMAIL' => 'N/A'];
    }
}
