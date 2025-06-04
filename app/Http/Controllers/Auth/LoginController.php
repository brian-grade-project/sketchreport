<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function login(): Response
    {
        // Si el usuario ya está autenticado, redirigir al inicio
        if (Auth::check()) {
            return redirect()->route('home');
        }

        // Regenerar la sesión y el token CSRF
        session()->regenerate();
        session()->regenerateToken();
        
        // Prevenir el almacenamiento en caché de la página de login
        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function check(Request $request): RedirectResponse
    {
        // Si el usuario ya está autenticado, redirigir al inicio
        if (Auth::check()) {
            return redirect()->route('home');
        }

        // Regenerar el token CSRF antes de la validación
        $request->session()->regenerateToken();

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
