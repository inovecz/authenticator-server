<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserLoginRequest;

class AuthController extends Controller
{
    public function loginPost(UserLoginRequest $request): JsonResponse|UserResource
    {
        Auth::guard('user')->attempt($request->all(['email', 'password']), $request->input('remember', false));
        $user = Auth::user();
        if ($user) {
            return $user->getResource();
        }
        return response()->json(['message' => 'TBD API -> Login']);
    }

    public function registerPost(Request $request): JsonResponse
    {
        return response()->json(['message' => 'TBD API -> Register']);
    }

    public function resetPasswordPost(Request $request): JsonResponse
    {
        return response()->json(['message' => 'TBD API -> ResetPassword']);
    }
}
