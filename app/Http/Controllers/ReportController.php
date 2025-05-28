<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

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
        Log::info('Método create llamado', ['request' => $request->all()]);
        
        if ($request->has('view')) {
            try {
                Log::info('Intentando cargar reporte para ver', ['id' => $request->view]);
                $reporte = Report::with('media_files')->findOrFail($request->view);
                
                Log::info('Reporte encontrado', [
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
                Log::error('Error al cargar el reporte: ' . $e->getMessage());
                return redirect()->route('reporte.index')
                    ->with('error', 'Error al cargar el reporte: ' . $e->getMessage());
            }
        }
        
        Log::info('Creando nuevo reporte');
        return view('report.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Método store llamado', ['request_data' => $request->all()]);
        
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'report_date' => 'required|date',
                'media.*' => 'nullable|file|max:102400' // Adjusted max file size
            ]);

            $report = new Report();
            $report->title = $request->title;
            $report->text = $request->content;
            $report->report_date = $request->report_date;
            $report->user_id = auth()->id();
            $report->save();

            Log::info('Reporte guardado', ['report_id' => $report->id]);

            // Procesar archivos si existen
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    Log::info('Procesando archivo multimedia', ['file_name' => $file->getClientOriginalName()]);
                    $path = $file->store('public/reports/' . $report->id);
                    $report->media_files()->create([
                        'file_path' => str_replace('public/', '', $path),
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize()
                    ]);
                    Log::info('Archivo multimedia guardado', ['path' => $path]);
                }
            }

            // Si es una solicitud AJAX o se solicita JSON
            if ($request->ajax() || $request->wantsJson()) {
                Log::info('Respondiendo con JSON', ['report_id' => $report->id]);
                return response()->json([
                    'success' => true,
                    'message' => 'Reporte guardado exitosamente.',
                    'report_id' => $report->id
                ]);
            }

            // Si no es AJAX, redirigir normalmente
            Log::info('Redirigiendo después de guardar', ['report_id' => $report->id]);
            return redirect()->route('reporte.index')
                ->with('success', 'Reporte creado exitosamente');
                
        } catch (\Exception $e) {
            Log::error('Error al crear el reporte: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            
            // Si es una solicitud AJAX o se solicita JSON
            if ($request->ajax() || $request->wantsJson()) {
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
        Log::info('Método show llamado', ['report_id' => $report->id]);
        
        try {
            // Cargar el reporte con sus archivos multimedia
            $reporte = Report::with('media_files')->findOrFail($report->id);
            Log::info('Reporte encontrado', ['reporte_id' => $reporte->id]);
            
            // Depurar los datos
            Log::info('Datos del reporte:', [
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
            Log::error('Error en show method: ' . $e->getMessage());
            return redirect()->route('reporte.index')
                ->with('error', 'Error al mostrar el reporte: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        Log::info('Método edit llamado', [
            'id' => $id,
            'auth_check' => auth()->check(),
            'user' => auth()->user()
        ]);
        
        try {
            // Cargar el reporte con sus archivos multimedia
            $reporte = Report::with('media_files')->findOrFail($id);
            
            Log::info('Reporte encontrado', [
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
            Log::error('Error en edit method: ' . $e->getMessage(), [
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
        Log::info('Método update llamado', [
            'id' => $id,
            'request_data' => $request->all()
        ]);

        try {
            $report = Report::findOrFail($id);
            
            Log::info('Reporte encontrado para actualizar', [
                'id' => $report->id,
                'current_title' => $report->title,
                'current_text' => $report->text,
                'current_date' => $report->report_date
            ]);

            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'report_date' => 'required|date',
                'media.*' => 'nullable|file|max:102400' // Adjusted max file size
            ]);

            $report->title = $request->input('title');
            $report->text = $request->input('content');
            $report->report_date = $request->input('report_date');
            
            Log::info('Datos a actualizar', [
                'title' => $report->title,
                'text' => $report->text,
                'report_date' => $report->report_date
            ]);

            $saved = $report->save();

            Log::info('Reporte actualizado', ['report_id' => $report->id]);

            // Procesar nuevos archivos si existen
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    Log::info('Procesando nuevo archivo multimedia', ['file_name' => $file->getClientOriginalName()]);
                    $path = $file->store('public/reports/' . $report->id);
                    $mediaFile = $report->media_files()->create([
                        'file_path' => str_replace('public/', '', $path),
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize()
                    ]);

                    Log::info('Nuevo archivo multimedia agregado', [
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'media_file_id' => $mediaFile->id
                    ]);
                }
            }

            // Si es una solicitud AJAX o se solicita JSON
            if ($request->ajax() || $request->wantsJson()) {
                Log::info('Respondiendo con JSON', ['report_id' => $report->id]);
                return response()->json([
                    'success' => true,
                    'message' => 'Reporte actualizado exitosamente.',
                    'report_id' => $report->id
                ]);
            }

            // Si no es AJAX, redirigir normalmente
            Log::info('Redirigiendo después de actualizar', ['report_id' => $report->id]);
            return redirect()->route('reporte.index')
                ->with('success', 'Reporte actualizado exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al actualizar el reporte: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            
            // Si es una solicitud AJAX o se solicita JSON
            if ($request->ajax() || $request->wantsJson()) {
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
        Log::info('Método destroy llamado', ['id' => $id]);
        
        try {
            $reporte = Report::findOrFail($id);

            // Eliminar archivos multimedia asociados si existen
            if ($reporte->media_files) {
                foreach ($reporte->media_files as $media) {
                     // Delete from storage
                    if (Storage::exists('public/' . $media->file_path)) {
                        Storage::delete('public/' . $media->file_path);
                         Log::info('Archivo multimedia eliminado del storage', ['path' => $media->file_path]);
                    }
                    // Delete from database
                    $media->delete();
                     Log::info('Registro multimedia eliminado de la BD', ['id' => $media->id]);
                }
            }
            
             // Eliminar la carpeta del reporte si está vacía
            $reportDir = 'public/reports/' . $reporte->id;
            if (Storage::exists($reportDir) && count(Storage::files($reportDir)) === 0 && count(Storage::directories($reportDir)) === 0) {
                Storage::deleteDirectory($reportDir);
                 Log::info('Directorio de reporte eliminado del storage', ['dir' => $reportDir]);
            }

            $reporte->delete();
            Log::info('Reporte eliminado exitosamente', ['id' => $id]);

            return redirect()->route('reporte.index')
                ->with('success', 'Reporte eliminado exitosamente.');
        } catch (\Exception $e) {
             Log::error('Error al eliminar el reporte: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->back()
                ->with('error', 'Error al eliminar el reporte: ' . $e->getMessage());
        }
    }

    /**
     * Export the specified report as a ZIP file.
     */
    public function export(Report $report)
    {
        Log::info('Método export llamado', ['report_id' => $report->id]);

        try {
            // Load media files if not already loaded
            $report->loadMissing('media_files');

            // Generate report text content
            $reportContent = "Título: " . $report->title . "\n";
            $reportContent .= "Fecha: " . $report->report_date->format('Y-m-d') . "\n\n";
            $reportContent .= "Contenido:\n" . $report->text;

            // Create a temporary file for the report text
            $textFileName = 'reporte_' . $report->id . '.txt';
            $tempTextFilePath = tempnam(sys_get_temp_dir(), 'report_txt_export');
            file_put_contents($tempTextFilePath, $reportContent);
            Log::info('Archivo de texto temporal creado', ['path' => $tempTextFilePath]);

            // Create a temporary directory for the zip file
            $zipFileName = 'reporte_' . $report->id . '_' . now()->format('Ymd_His') . '.zip';
            $tempZipFilePath = tempnam(sys_get_temp_dir(), 'report_zip_export');
            // Delete the temporary file created by tempnam, we only need the name
            unlink($tempZipFilePath);
            $tempZipFilePath .= '.zip'; // Add .zip extension
            Log::info('Archivo zip temporal creado', ['path' => $tempZipFilePath]);

            $zip = new ZipArchive();

            if ($zip->open($tempZipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                Log::info('Zip file opened', ['path' => $tempZipFilePath]);
                // Add the report text file to the zip
                $zip->addFile($tempTextFilePath, $textFileName);
                Log::info('Texto del reporte añadido al zip', ['file' => $textFileName]);

                // Add associated media files to the zip
                foreach ($report->media_files as $media) {
                    $storagePath = 'public/' . $media->file_path;
                    if (Storage::exists($storagePath)) {
                        $mediaContent = Storage::get($storagePath);
                        $zip->addFromString('media/' . $media->file_name, $mediaContent);
                        Log::info('Archivo multimedia añadido al zip', ['file' => $media->file_name]);
                    } else {
                        Log::warning('Archivo multimedia no encontrado en storage', ['path' => $storagePath]);
                    }
                }

                $zip->close();
                Log::info('Zip file cerrado', ['path' => $tempZipFilePath]);

                // Set appropriate headers for download
                $headers = [
                    'Content-Type' => 'application/zip',
                    'Content-Disposition' => 'attachment; filename="' . $zipFileName . '";',
                    'Content-Length' => filesize($tempZipFilePath),
                ];

                // Return the zip file as a download
                Log::info('Retornando archivo zip para descarga', ['file' => $zipFileName, 'size' => filesize($tempZipFilePath)]);
                return Response::download($tempZipFilePath, $zipFileName, $headers)->deleteFileAfterSend(true);

            } else {
                Log::error('No se pudo crear/abrir el archivo zip', ['path' => $tempZipFilePath]);
                 // Clean up temporary text file
                unlink($tempTextFilePath);
                // Return a standard error response if zip creation fails
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el archivo zip.',
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Error durante la exportacion del reporte: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // Clean up temporary text file if it was created
            if (isset($tempTextFilePath) && file_exists($tempTextFilePath)) {
                unlink($tempTextFilePath);
            }
             // Clean up temporary zip file if it was created
            if (isset($tempZipFilePath) && file_exists($tempZipFilePath)) {
                 unlink($tempZipFilePath);
            }
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar el reporte: ' . $e->getMessage()
            ], 500);
        }
    }
}
