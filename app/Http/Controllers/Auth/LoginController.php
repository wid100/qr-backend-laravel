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
        if (in_array($user->role_id, [1, 3])) {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/home');
    }
}
