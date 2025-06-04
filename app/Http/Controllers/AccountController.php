<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function delete(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Aquí puedes agregar la lógica para eliminar datos relacionados
            // Por ejemplo, eliminar archivos, registros en otras tablas, etc.
            
            // Eliminar la cuenta del usuario
            $user->delete();
            
            // Cerrar la sesión
            Auth::logout();
            
            // Redirigir al login con mensaje de éxito
            return redirect()->route('login')->with('success', 'Tu cuenta ha sido eliminada exitosamente.');
        } catch (\Exception $e) {
            // Redirigir de vuelta al perfil con mensaje de error
            return redirect()->route('profile')->with('error', 'Error al eliminar la cuenta. Por favor, intenta nuevamente.');
        }
    }
} 