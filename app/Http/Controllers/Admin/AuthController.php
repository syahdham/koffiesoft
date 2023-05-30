<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{

    public function login(): View
    {
        return view('auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return json_encode([true, 'Login success']);
        }

        return json_encode([false, 'The provided credentials do not match our records']);
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function doRegister(RegisterRequest $request): bool|string
    {
        $user = User::create($request->validated());

        if ($user) return json_encode([true, 'Registered user success']);

        return json_encode([false, 'Oops, something went wrong']);
    }

    public function doLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
