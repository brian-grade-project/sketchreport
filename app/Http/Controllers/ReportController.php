<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Report::where('user_id', auth()->id())->with('media_files');

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('text', 'like', '%' . $searchTerm . '%');
            });
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
                
                // Verificar que el reporte pertenece al usuario
                if ($reporte->user_id !== auth()->id()) {
                    return redirect()->route('reporte.index')
                        ->with('error', 'No tienes permiso para ver este reporte.');
                }
                
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
                    'report_id' => $report->id,
                    'redirect' => route('reporte.index')
                ]);
            }

            return redirect()->route('reporte.index')
                ->with('success', 'Reporte creado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al crear el reporte: ' . $e->getMessage());
            
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
            // Verificar que el reporte pertenece al usuario
            if ($report->user_id !== auth()->id()) {
                return redirect()->route('reporte.index')
                    ->with('error', 'No tienes permiso para ver este reporte.');
            }

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
            
            // Verificar que el reporte pertenece al usuario
            if ($reporte->user_id !== auth()->id()) {
                return redirect()->route('reporte.index')
                    ->with('error', 'No tienes permiso para editar este reporte.');
            }
            
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
            $reporte = Report::findOrFail($id);

            // Verificar que el reporte pertenece al usuario
            if ($reporte->user_id !== auth()->id()) {
                return redirect()->route('reporte.index')
                    ->with('error', 'No tienes permiso para actualizar este reporte.');
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'report_date' => 'required|date',
                'media.*' => 'nullable|file|max:10240', // 10MB máximo por archivo
                'delete_media' => 'nullable|array',
                'delete_media.*' => 'exists:media_files,id'
            ]);

            $reporte->title = $request->title;
            $reporte->text = $request->content;
            $reporte->report_date = $request->report_date;
            $reporte->save();

            // Eliminar archivos multimedia seleccionados
            if ($request->has('delete_media')) {
                foreach ($request->delete_media as $mediaId) {
                    $media = $reporte->media_files()->find($mediaId);
                    if ($media) {
                        if (Storage::exists('public/' . $media->file_path)) {
                            Storage::delete('public/' . $media->file_path);
                        }
                        $media->delete();
                    }
                }
            }

            // Procesar nuevos archivos si existen
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store('public/reports/' . $reporte->id);
                    $reporte->media_files()->create([
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
                    'message' => 'Reporte actualizado exitosamente',
                    'report_id' => $reporte->id,
                    'redirect' => route('reporte.index')
                ]);
            }

            return redirect()->route('reporte.index')
                ->with('success', 'Reporte actualizado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error en update method: ' . $e->getMessage());
            
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
            $reporte = Report::findOrFail($id);

            // Verificar que el reporte pertenece al usuario
            if ($reporte->user_id !== auth()->id()) {
                return redirect()->route('reporte.index')
                    ->with('error', 'No tienes permiso para eliminar este reporte.');
            }

            // Eliminar archivos multimedia asociados
            foreach ($reporte->media_files as $media) {
                if (Storage::exists('public/' . $media->file_path)) {
                    Storage::delete('public/' . $media->file_path);
                }
                $media->delete();
            }

            // Eliminar el reporte
            $reporte->delete();

            return redirect()->route('reporte.index')
                ->with('success', 'Reporte eliminado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error en destroy method: ' . $e->getMessage());
            return redirect()->route('reporte.index')
                ->with('error', 'Error al eliminar el reporte: ' . $e->getMessage());
        }
    }

    /**
     * Export the report and its media files as a ZIP file.
     */
    public function export($id)
    {
        try {
            $report = Report::with('media_files')->findOrFail($id);

            // Verificar que el reporte pertenece al usuario
            if ($report->user_id !== auth()->id()) {
                return redirect()->route('reporte.index')
                    ->with('error', 'No tienes permiso para exportar este reporte.');
            }

            // Crear un archivo ZIP temporal
            $zip = new \ZipArchive();
            $zipFileName = 'reporte_' . $report->id . '_' . time() . '.zip';
            $zipPath = storage_path('app/public/temp/' . $zipFileName);

            // Asegurarse de que el directorio temporal existe
            if (!file_exists(storage_path('app/public/temp'))) {
                mkdir(storage_path('app/public/temp'), 0755, true);
            }

            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                // Agregar el contenido del reporte como un archivo de texto
                $reportContent = "Título: " . $report->title . "\n";
                $reportContent .= "Fecha: " . $report->report_date . "\n\n";
                $reportContent .= "Contenido:\n" . $report->text;
                $zip->addFromString('reporte.txt', $reportContent);

                // Agregar los archivos multimedia
                foreach ($report->media_files as $media) {
                    $filePath = storage_path('app/public/' . $media->file_path);
                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, 'media/' . basename($media->file_path));
                    }
                }

                $zip->close();

                // Descargar el archivo ZIP
                return response()->download($zipPath)->deleteFileAfterSend(true);
            } else {
                throw new \Exception('No se pudo crear el archivo ZIP');
            }
        } catch (\Exception $e) {
            \Log::error('Error al exportar el reporte: ' . $e->getMessage());
            return redirect()->route('reporte.index')
                ->with('error', 'Error al exportar el reporte: ' . $e->getMessage());
        }
    }
}
