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
        $reportes = Report::with('media_files')->latest()->take(7)->get();
        $multimedias = Multimedia::latest()->take(7)->get();

        // dd($reportes);
        return view('auth.inicio', compact('reportes', 'multimedias'));
    }
}
