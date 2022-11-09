<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function updateProfilePost(Request $request): JsonResponse
    {
        return response()->json(['message' => 'TBD API -> Update profile']);
    }

    public function changePasswordPost(Request $request): JsonResponse
    {
        return response()->json(['message' => 'TBD API -> Change password']);
    }
}
