<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => [
                'required',
                'confirmed',
                'min:8',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/[A-Z]/', $value)) {
                        $fail('La contraseña debe contener al menos una letra mayúscula.');
                    }
                    if (!preg_match('/[a-z]/', $value)) {
                        $fail('La contraseña debe contener al menos una letra minúscula.');
                    }
                    if (!preg_match('/[0-9]/', $value)) {
                        $fail('La contraseña debe contener al menos un número.');
                    }
                    if (!preg_match('/[^A-Za-z0-9]/', $value)) {
                        $fail('La contraseña debe contener al menos un símbolo especial.');
                    }
                },
            ],
        ], [
            'current_password.required' => 'La contraseña actual es requerida.',
            'current_password.current_password' => 'La contraseña actual es incorrecta.',
            'new_password.required' => 'La nueva contraseña es requerida.',
            'new_password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'new_password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', '¡Contraseña actualizada exitosamente!');
    }
}
