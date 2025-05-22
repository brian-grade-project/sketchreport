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
    public function create(Request $request)
    {
        \Log::info('Método create llamado', ['request' => $request->all()]);
        
        if ($request->has('view')) {
            try {
                \Log::info('Intentando cargar reporte para ver', ['id' => $request->view]);
                $reporte = Report::with('media_files')->findOrFail($request->view);
                
                \Log::info('Reporte encontrado', [
                    'id' => $reporte->id,
                    'title' => $reporte->title,
                    'text' => $reporte->text,
                    'report_date' => $reporte->report_date,
                    'media_files_count' => $reporte->media_files->count()
                ]);

                $isReadOnly = true;
                return view('report.create', [
                    'reporte' => $reporte,
                    'isReadOnly' => true
                ]);
            } catch (\Exception $e) {
                \Log::error('Error al cargar el reporte: ' . $e->getMessage());
                return redirect()->route('reporte.index')
                    ->with('error', 'Error al cargar el reporte: ' . $e->getMessage());
            }
        }
        
        \Log::info('Creando nuevo reporte');
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
        \Log::info('Método show llamado', ['report_id' => $report->id]);
        
        try {
            // Cargar el reporte con sus archivos multimedia
            $reporte = Report::with('media_files')->findOrFail($report->id);
            \Log::info('Reporte encontrado', ['reporte_id' => $reporte->id]);
            
            // Depurar los datos
            \Log::info('Datos del reporte:', [
                'id' => $reporte->id,
                'title' => $reporte->title,
                'text' => $reporte->text,
                'report_date' => $reporte->report_date,
                'media_files' => $reporte->media_files->toArray(),
                'raw_data' => $reporte->toArray(),
                'attributes' => $reporte->getAttributes()
            ]);
            
            // Pasar el reporte a la vista create en modo lectura
            return view('report.create', [
                'reporte' => $reporte,
                'isReadOnly' => true
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en show method: ' . $e->getMessage());
            return redirect()->route('reporte.index')
                ->with('error', 'Error al mostrar el reporte: ' . $e->getMessage());
        }
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
