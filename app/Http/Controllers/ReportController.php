<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reportes = Report::with('media_files')->paginate(15);
        return view('report.index', compact('reportes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('report.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'report_date' => 'required|date',
                'media.*' => 'nullable|file|max:10240' // 10MB máximo por archivo
            ]);

        $report = new Report();
            $report->title = $request->title;
            $report->text = $request->content;
            $report->report_date = $request->report_date;
            $report->user_id = auth()->id();
            $report->save();

            // Procesar archivos si existen
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store('public/reports/' . $report->id);
                    $report->media_files()->create([
                        'file_path' => str_replace('public/', '', $path),
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize()
                    ]);
                }
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reporte creado exitosamente',
                    'redirect' => route('reporte.index')
                ]);
            }

            return redirect()->route('reporte.index')
                ->with('success', 'Reporte creado exitosamente');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el reporte: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->with('error', 'Error al crear el reporte: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
