<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Report::with('media_files');

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('text', 'like', '%' . $searchTerm . '%');
        }

        $reportes = $query->paginate(15);

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
    public function edit($id)
    {
        \Log::info('Método edit llamado', [
            'id' => $id,
            'auth_check' => auth()->check(),
            'user' => auth()->user()
        ]);
        
        try {
            // Cargar el reporte con sus archivos multimedia
            $reporte = Report::with('media_files')->findOrFail($id);
            
            \Log::info('Reporte encontrado', [
                'reporte_id' => $reporte->id,
                'title' => $reporte->title,
                'media_files_count' => $reporte->media_files->count()
            ]);
            
            // Pasar el reporte a la vista create en modo edición
            return view('report.create', [
                'reporte' => $reporte,
                'isReadOnly' => false,
                'isEdit' => true
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en edit method: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('reporte.index')
                ->with('error', 'Error al cargar el reporte para edición: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        \Log::info('Método update llamado', [
            'id' => $id,
            'request_data' => $request->all()
        ]);

        try {
            // Buscar el reporte específico
            $report = Report::findOrFail($id);
            
            \Log::info('Reporte encontrado para actualizar', [
                'id' => $report->id,
                'current_title' => $report->title,
                'current_text' => $report->text,
                'current_date' => $report->report_date
            ]);

            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'report_date' => 'required|date',
                'media.*' => 'nullable|file|max:10240' // 10MB máximo por archivo
            ]);

            // Actualizar los datos básicos del reporte
            $report->title = $request->input('title');
            $report->text = $request->input('content');
            $report->report_date = $request->input('report_date');
            
            \Log::info('Datos a actualizar', [
                'title' => $report->title,
                'text' => $report->text,
                'report_date' => $report->report_date
            ]);

            $saved = $report->save();

            \Log::info('Resultado de la actualización', [
                'saved' => $saved,
                'updated_report' => $report->fresh()->toArray()
            ]);

            // Procesar nuevos archivos si existen
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store('public/reports/' . $report->id);
                    $mediaFile = $report->media_files()->create([
                        'file_path' => str_replace('public/', '', $path),
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize()
                    ]);

                    \Log::info('Archivo multimedia agregado', [
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'media_file_id' => $mediaFile->id
                    ]);
                }
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reporte actualizado exitosamente',
                    'redirect' => route('reporte.index')
                ]);
            }

            return redirect()->route('reporte.index')
                ->with('success', 'Reporte actualizado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al actualizar el reporte: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'id' => $id
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el reporte: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->with('error', 'Error al actualizar el reporte: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            \Log::info('Método destroy llamado', ['id' => $id]);
            
            $report = Report::findOrFail($id);
            
            // Eliminar archivos multimedia asociados
            foreach ($report->media_files as $media) {
                // Eliminar archivo físico
                $filePath = storage_path('app/public/' . $media->file_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                // Eliminar registro de la base de datos
                $media->delete();
            }
            
            // Eliminar el reporte
            $report->delete();
            
            \Log::info('Reporte eliminado exitosamente', ['id' => $id]);
            
            return redirect()->route('reporte.index')
                ->with('success', 'Reporte eliminado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar el reporte: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('reporte.index')
                ->with('error', 'Error al eliminar el reporte: ' . $e->getMessage());
        }
    }
}
