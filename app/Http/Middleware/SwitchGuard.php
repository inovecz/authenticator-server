<?php
declare(strict_types=1);
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class SwitchGuard
{
    public function handle(Request $request, Closure $next, string $guard = null): Response|RedirectResponse
    {
        if (array_key_exists($guard, config('auth.guards'))) {
            config(['auth.defaults.guard' => $guard]);
        }
        return $next($request);
    }
}
