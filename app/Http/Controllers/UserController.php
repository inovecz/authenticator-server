<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use OpenApi\Annotations as OA;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Services\ScoreEngineService;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UpdateOrCreateUserRequest;

class UserController extends Controller
{
    public function __construct(protected ScoreEngineService $scoreEngineService)
    {
        $this->scoreEngineService->isApiCall = true;
    }

    /**
     * @OA\Post(
     *      path="/api/users",
     *      summary="Update or create user",
     *      description="Save user record",
     *      operationId="usersUpdateOrCreate",
     *      tags={"user"},
     *      @OA\RequestBody(
     *         required=true,
     *         description="Pass user record data",
     *         @OA\JsonContent(
     *              required={"name", "surname", "email"},
     *              @OA\Property(property="hash", type="string", example="97dfab9823664071a0b767ae3eb5a0ca", nullable="true", description="Identificator of the user record. If provided, update is performed"),
     *              @OA\Property(property="name", type="string", example="Oto", description="User's name"),
     *              @OA\Property(property="surname", type="string", example="Novák", description="User's surname"),
     *              @OA\Property(property="email", type="string", format="email", example="oto.novak@email.cz", description="User's e-mail"),
     *              @OA\Property(property="gender", type="string", nullable="true", enum={"MALE","FEMALE","OTHER"}, example="OTHER", description="User's gender"),
     *              @OA\Property(property="password", type="string", nullable="true", example="Password1234", description="User's password"),
     *              @OA\Property(property="password_confirmation", type="string", nullable="true", example="Password1234", description="User's password confirmation"),
     *         ),
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *            @OA\Property(property="UserResource", type="object", ref="#/components/schemas/UserResource")
     *         )
     *      ),
     *      @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *          @OA\Schema(type="string"),
     *                   @OA\Examples(example="string1", value="The email has already been taken.", summary="Email exists"),
     *                   @OA\Examples(example="string2", value="The email must be a valid email address.", summary="Invalid e-mail"),
     *                   @OA\Examples(example="string3", value="The phone has already been taken.", summary="Phone exists"),
     *                   @OA\Examples(example="string4", value="The phone format is invalid.", summary="Invalid phone format"),
     *                   @OA\Examples(example="string5", value="The selected hash is invalid.", summary="Invalid hash"),
     *                   @OA\Examples(example="string6", value="The * field is required.", summary="Missing required field"),
     *                   @OA\Examples(example="string7", value="The password confirmation does not match.", summary="Password not matching"),
     *         )
     *      ),
     * )
     */
    public function updateOrcreate(UpdateOrCreateUserRequest $request): UserResource
    {
        $hash = $request->input('hash');
        $data = $request->all('name', 'surname', 'gender', 'email', 'phone');
        if ($request->input('password')) {
            $data['password'] = $request->input('password');
        }
        $userService = new UserService();
        $user = $userService->updateOrCreate($data, $hash);
        return new UserResource($user);
    }

    /**
     * @OA\Delete(
     *      path="/api/users",
     *      summary="Delete user record",
     *      description="Delete user record",
     *      operationId="userDestroy",
     *      tags={"user"},
     *      @OA\RequestBody(
     *         required=true,
     *         description="Pass blacklist record identificator",
     *         @OA\JsonContent(
     *              required={"_method", "hash"},
     *              @OA\Property(property="_method", type="string", example="delete", description="Router method specification - always 'delete'"),
     *              @OA\Property(property="hash", type="string", example="97dfab9823664071a0b767ae3eb5a0ca", description="Identificator of the user record"),
     *         ),
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *            @OA\Property(property="message",type="string", example="user.deleted")
     *         )
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *            @OA\Property(property="error", type="string", example="user.delete_failed"),
     *         )
     *      ),
     *      @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *          @OA\Schema(type="string"),
     *                   @OA\Examples(example="string1", value="The selected hash is invalid.", summary="Invalid hash"),
     *         )
     *      ),
     * )
     */
    public function destroy(UserDeleteRequest $request): JsonResponse
    {
        $deleted = User::where($request->only('hash'))->delete();
        return $deleted
            ? $this->success('user.deleted')
            : $this->error('user.delete_failed');
    }
}
