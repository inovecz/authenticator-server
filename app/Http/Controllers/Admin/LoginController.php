<?php

namespace App\Http\Controllers\Admin;

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
        if ($admin = Auth::guard('admin')->user()) {
            Auth::login($admin, $remember);
            return redirect(route('dashboard'));
        }
        return redirect()->back();
    }
    // </editor-fold desc="Region: ADMIN">
}
