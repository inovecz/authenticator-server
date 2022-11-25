<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\ScoreEngineService;
use App\Http\Requests\SettingUpdateRequest;

class SettingController extends Controller
{
    public function __construct(protected ScoreEngineService $scoreEngineService)
    {
        $this->scoreEngineService->isApiCall = true;
    }

    /**
     * @OA\Post(
     *      path="/api/settings",
     *      summary="Update setting value",
     *      description="Update setting value",
     *      operationId="settingUpdate",
     *      tags={"setting"},
     *      @OA\RequestBody(
     *         required=true,
     *         description="Pass setting key-value pair",
     *         @OA\JsonContent(
     *              required={"key", "value"},
     *              @OA\Property(property="key", type="string", example="scoring.password.leaks", description="Setting's key name (in dotted notation)"),
     *              @OA\Property(property="value", type="string", description="The value of the setting (int|string|bool)"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="setting.dotted.path", type="string", example=true)
     *          )
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="Sorry, the requested resource could not be found"),
     *         )
     *      ),
     * )
     */
    public function update(SettingUpdateRequest $request): JsonResponse
    {
        return $this->scoreEngineService->updateSetting($request->input('key'), $request->input('value'));
    }
}
