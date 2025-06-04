<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    public function create(): Response
    {
        // Si el usuario ya está autenticado, redirigir al inicio
        if (Auth::check()) {
            return redirect()->route('home');
        }

        // Regenerar la sesión y el token CSRF
        session()->regenerate();
        session()->regenerateToken();
        
        // Prevenir el almacenamiento en caché de la página de registro
        return response()
            ->view('auth.register')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[A-Z]/', // Al menos una letra mayúscula
                    'regex:/[!@#$%^&*(),.?":{}|<>]/', // Al menos un carácter especial
                ],
                'terms' => 'required'
            ], [
                'name.required' => 'El nombre es obligatorio',
                'lastname.required' => 'Los apellidos son obligatorios',
                'email.required' => 'El correo electrónico es obligatorio',
                'email.email' => 'El correo electrónico debe ser válido',
                'email.unique' => 'Este correo electrónico ya está registrado',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden',
                'password.regex' => 'La contraseña debe contener al menos una letra mayúscula y un carácter especial (!@#$%^&*(),.?":{}|<>)',
                'terms.required' => 'Debes aceptar los términos y condiciones'
            ]);

            // Generar username basado en el email
            $username = Str::before($request->email, '@');

            $user = User::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'username' => $username,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);

            return redirect()->route('home')->with('success', '¡Cuenta creada exitosamente!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->validator);
        }
    }
} 