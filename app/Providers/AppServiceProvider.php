<?php

namespace App\Providers;

use Illuminate\Http\Client\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('toJsonResponse', static function (Response $response) {
            return response()->json($response->json(), $response->status());
        });
        JsonResource::withoutWrapping();
    }
}
