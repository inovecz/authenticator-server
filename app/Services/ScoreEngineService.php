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
        $data['hash'] = User::where('email', $data['email'])->first('hash')->getHash();
        unset($data['email']);
        $data['user-agent'] = $request->userAgent();
        $data['ip'] = $request->getClientIp();
        $response = Http::post(config('app.scoring_engine_api') . '/score-login', $data);
        return array_merge($response->json(), ['duration' => round(microtime(true) - $start,2)]);
    }
}
