<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Multimedia;

class HomeController extends Controller
{
    //
    public function inicio(): View
    {
        // Obtener el usuario actual
        $user = auth()->user();

        // Obtener los últimos 7 reportes del usuario actual
        $reportes = Report::with('media_files')
            ->where('user_id', $user->id)
            ->latest()
            ->take(7)
            ->get();

        // Obtener los últimos 7 archivos multimedia del usuario actual
        $multimedias = Multimedia::where('user_id', $user->id)
            ->latest()
            ->take(7)
            ->get();

        // dd($reportes);
        return view('auth.inicio', compact('reportes', 'multimedias'));
    }
}
