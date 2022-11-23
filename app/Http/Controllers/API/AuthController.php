<?php

namespace App\Http\Controllers\API;

use Str;
use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\ResetPasswordRequest;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/auth/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user@inove.cz"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       @OA\Property(property="remember", type="boolean", example="true"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="UserResource", type="object", ref="#/components/schemas/UserResource")
     *    )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again"),
     *    )
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Validation errors",
     *    @OA\JsonContent(
     *     @OA\Schema(type="string"),
     *              @OA\Examples(example="string1", value="The email field is required.", summary="The email field is required."),
     *              @OA\Examples(example="string2", value="The selected email is invalid.", summary="The selected email is invalid."),
     *              @OA\Examples(example="string3", value="The password field is required.", summary="The password field is required."),
     *    )
     * )
     * )
     */
    public function loginPost(UserLoginRequest $request): JsonResponse|UserResource
    {
        Auth::guard('user')->attempt($request->only('email', 'password'), $request->input('remember', false));
        $user = Auth::user();
        if ($user) {
            return $user->getResource();
        }
        return $this->unauthorized();
    }

    public function loginAdminPost(AdminLoginRequest $request): JsonResponse|UserResource
    {
        Auth::guard('admin')->attempt($request->only(['email', 'password']), $request->input('remember', false));
        $user = Auth::guard('admin')->user();
        if ($user) {
            return $user->getResource();
        }
        return $this->unauthorized();
    }

    /**
     * @OA\Post(
     * path="/api/auth/register",
     * summary="Registration",
     * description="Create new user",
     * operationId="authRegister",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user information",
     *    @OA\JsonContent(
     *       required={"name","surname","email","password", "password_confirmation"},
     *       @OA\Property(property="name", type="string", format="email", example="Jan"),
     *       @OA\Property(property="surname", type="string", format="email", example="Novák"),
     *       @OA\Property(property="gender", type="string", enum={"MALE","FEMALE","OTHER"}, example="OTHER", default="OTHER"),
     *       @OA\Property(property="email", type="string", format="email", example="jan.novak@seznam.cz"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *      @OA\Property(property="password_confirmation", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Created",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="User has been successfuly created")
     *    )
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Validation errors",
     *    @OA\JsonContent(
     *     @OA\Schema(type="string"),
     *              @OA\Examples(example="string1", value="The email has already been taken.", summary="Email already exists"),
     *              @OA\Examples(example="string2", value="The selected gender is invalid.", summary="Invalid gender"),
     *              @OA\Examples(example="string3", value="The * field is required.", summary="Required field"),
     *              @OA\Examples(example="string4", value="The password confirmation does not match.", summary="Password confirmation"),
     *              @OA\Examples(example="string5", value="The password must be at least 8 characters.", summary="Password length"),
     *    )
     * )
     * )
     */
    public function registerPost(UserRegisterRequest $request): JsonResponse
    {
        $user = User::create(
            array_merge(
                $request->only('name', 'surname', 'gender', 'email'),
                ['password' => \Hash::make($request->input('password'))]
            )
        );
        event(new Registered($user));
        return $this->created('User has been successfuly created');
    }

    public function verifyEmail(Request $request): JsonResponse
    {
        if (!hash_equals((string) $request->route('id'),
            (string) $request->user()->getKey())) {
            return $this->error('User is not signed in');
        }

        if (!hash_equals((string) $request->route('hash'),
            sha1($request->user()->getEmailForVerification()))) {
            return $this->error('Wrong verification checksum');
        }

        if (!$request->user()->hasVerifiedEmail()) {
            $request->user()->markEmailAsVerified();

            event(new Verified($request->user()));
        }

        return $this->success('Email has been successfuly verified');
    }

    public function sendVerification(Request $request): JsonResponse
    {
        $request->user()->sendEmailVerificationNotification();
        return $this->success('Verification link sent');
    }

    public function forgotPasswordPost(Request $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status ? $this->success('Password reset link was sent') : $this->error('Unable to send password reset link');
    }

    public function resetPasswordPost(ResetPasswordRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            static function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status ? $this->success('Password has been successfuly reseted') : $this->error('Unable to reset password');
    }
}
