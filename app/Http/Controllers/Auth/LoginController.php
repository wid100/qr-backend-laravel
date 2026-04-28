<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * After successful login, redirect based on role_id.
     * role_id 1 = super-admin, role_id 3 = admin
     */
    protected function authenticated(Request $request, $user)
    {
        // NOTE: This project uses both legacy `role_id` and newer enum `role`.
        // Keep redirect logic compatible with both.
        if (($user->role ?? null) === 'admin' || in_array((int) $user->role_id, [1, 3], true)) {
            return redirect()->route('admin.dashboard');
        }

        // If doctor dashboard exists in future, redirect there.
        if (($user->role ?? null) === 'doctor') {
            return redirect('/home');
        }

        return redirect('/home');
    }
}
