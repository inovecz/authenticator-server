<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;

class LoginController extends Controller
{
    // <editor-fold desc="Region: ADMIN">
    public function loginPost(AdminLoginRequest $request)
    {
        $remember = $request->input('remember', false);
        Auth::guard('admin')->attempt($request->all(['email', 'password']), $remember);
        if (Auth::guard('admin')->user()) {
            return redirect(route('dashboard'));
        }
        return redirect(route('admin.loginPage'));
    }

    public function logoutPost(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect(route('admin.loginPage'));
    }
    // </editor-fold desc="Region: ADMIN">
}
