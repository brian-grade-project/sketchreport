<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    //
    public function login(): View
    {
        return view('auth.login');
    }

    public function check(Request $request): RedirectResponse
    {
        //
        $request->validate([]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return to_route('home');
        }

        return back()->with('status', 'Credenciales invalidas!');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        //TODO: invalidar token de sessión
        return to_route('inicio');
    }
}
