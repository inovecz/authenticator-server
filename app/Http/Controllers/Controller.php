<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *    title="Inove Authenticator API",
 *    version="1.0.0",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success(array|string $success): JsonResponse
    {
        return $this->respond(is_array($success) ? $success : ['message' => $success]);
    }

    public function created(array|string $created): JsonResponse
    {
        return $this->respond(is_array($created) ? $created : ['message' => $created], 201);
    }

    public function error(array|string $error): JsonResponse
    {
        return $this->respond(is_array($error) ? $error : ['error' => $error], 400);
    }

    public function unauthorized(): JsonResponse
    {
        return $this->respond(['message' => 'Sorry, wrong email address or password. Please try again'], 401);
    }

    public function permissionDenied(): JsonResponse
    {
        return $this->respond(['message' => 'Sorry, you are not allowed to make requested action'], 403);
    }

    public function notFound(array|string $message = null): JsonResponse
    {
        if (!$message) {
            return $this->respond(['message' => 'Sorry, the requested resource could not be found'], 404);
        }
        return $this->respond(is_array($message) ? $message : ['message' => $message], 404);
    }

    public function badRequest(): JsonResponse
    {
        return $this->respond(['message' => 'Sorry, the server cannot process the request due to an apparent client error'], 400);
    }

    public function respond(array $array, int $statusCode = 200): JsonResponse
    {
        return response()->json($array, $statusCode);
    }
}
