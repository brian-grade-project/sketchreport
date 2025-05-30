<?php

namespace App\Http\Controllers;

use App\Models\Multimedia;
use App\Services\FileTypeHandler;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class MultimediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Multimedia::latest();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('text', 'like', '%' . $searchTerm . '%');
        }

        $multimedias = $query->paginate(10);

        return view('multimedia.index', compact('multimedias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
        return view('multimedia.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'titulo' => 'required|string|max:255',
                'media_date' => 'required|date',
                'media.*' => [
                    'required',
                    'file',
                    'max:102400', // 100MB máximo por archivo
                    function ($attribute, $value, $fail) {
                        $allowedMimeTypes = [
                            // Imágenes
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/webp',
                            // Videos
                            'video/mp4',
                            'video/quicktime',
                            'video/x-msvideo',
                            'video/x-ms-wmv',
                            // Audio
                            'audio/mpeg',
                            'audio/wav',
                            'audio/ogg',
                            'audio/midi',
                            // Documentos
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-powerpoint',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'text/plain',
                        ];

                        if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
                            $fail('El tipo de archivo no está permitido.');
                        }
                    },
                ],
            ]);

            // Validar el tamaño total de los archivos
            $totalSize = 0;
            if ($request->hasFile('media')) {
                 foreach ($request->file('media') as $file) {
                    $totalSize += $file->getSize();
                }
            }

            // Convertir a MB
            $totalSizeMB = $totalSize / 1024 / 1024;
            if ($totalSizeMB > 100) {
                 // Si es una solicitud AJAX o se solicita JSON
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'El tamaño total de los archivos no puede exceder 100MB.'
                    ], 422);
                }
                return back()->with('error', 'El tamaño total de los archivos no puede exceder 100MB.');
            }

            $files = $request->file('media');
            $savedFiles = [];
            $multimediaIds = [];

            if ($files) {
            foreach ($files as $file) {
                // Procesar el archivo según su tipo
                $handler = new FileTypeHandler($file);
                $result = $handler->process();

                // Crear registro en la base de datos
                $multimedia = Multimedia::create([
                        'report_id' => $request->report_id, // Assuming report_id can be passed here if associated with a report
                    'path' => $result['path'],
                    'thumbnail' => $result['thumbnail'] ?? null,
                    'type' => $result['type'],
                    'text' => $request->titulo,
                    'media_date' => $request->media_date,
                    'metadata' => $result['metadata']
                ]);

                $savedFiles[] = $multimedia;
                    $multimediaIds[] = $multimedia->id;
                }
            }

            // Si es una solicitud AJAX o se solicita JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Archivos multimedia guardados exitosamente.',
                    'multimedia_ids' => $multimediaIds
                ]);
            }

            return redirect()->route('multimedia.index')
                ->with('success', 'Archivos multimedia guardados exitosamente.');

        } catch (Exception $e) {
             // Si es una solicitud AJAX o se solicita JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al guardar los archivos: ' . $e->getMessage()
                ], 422);
            }
            return back()->with('error', 'Error al guardar los archivos: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Multimedia $multimedia)
    {
        //
        return view('multimedia.show', compact('multimedia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Multimedia $multimedia)
    {
        //
        return view('multimedia.edit', compact('multimedia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Multimedia $multimedia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Multimedia $multimedia)
    {
        try {
            // Eliminar archivos físicos
            if ($multimedia->path) {
                Storage::disk('public')->delete($multimedia->path);
            }
            if ($multimedia->thumbnail) {
                Storage::disk('public')->delete($multimedia->thumbnail);
            }

            // Eliminar registro
            $multimedia->delete();

            return redirect()->route('multimedia.index')
                ->with('success', 'Archivo multimedia eliminado exitosamente.');
        } catch (Exception $e) {
            return back()->with('error', 'Error al eliminar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Test method to verify file uploads
     */
    public function testUpload(Request $request)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'titulo' => 'required|string|max:255',
                'media_date' => 'required|date',
                'media.*' => [
                    'required',
                    'file',
                    'max:102400', // 100MB máximo
                    function ($attribute, $value, $fail) {
                        $allowedMimeTypes = [
                            // Imágenes
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/webp',
                            // Videos
                            'video/mp4',
                            'video/quicktime',
                            'video/x-msvideo',
                            'video/x-ms-wmv',
                            // Audio
                            'audio/mpeg',
                            'audio/wav',
                            'audio/ogg',
                            'audio/midi',
                            // Documentos
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-powerpoint',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'text/plain',
                        ];

                        if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
                            $fail('El tipo de archivo no está permitido.');
                        }
                    },
                ],
            ]);

            $files = $request->file('media');
            $uploadResults = [];

            foreach ($files as $file) {
                $mimeType = $file->getMimeType();
                $size = $file->getSize();
                $originalName = $file->getClientOriginalName();
                
                $uploadResults[] = [
                    'nombre_original' => $originalName,
                    'tipo_mime' => $mimeType,
                    'tamaño_bytes' => $size,
                    'tamaño_mb' => round($size / 1024 / 1024, 2),
                    'extension' => $file->getClientOriginalExtension(),
                    'tipo_detectado' => $this->detectFileType($mimeType)
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Validación exitosa',
                'archivos' => $uploadResults
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la validación: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Helper method to detect file type
     */
    private function detectFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'imagen';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        } else {
            return 'documento';
        }
    }

    /**
     * Export the specified multimedia files as a ZIP file.
     */
    public function export(Request $request)
    {
        Log::info('Método export multimedia llamado', ['request_data' => $request->all()]);
        $multimediaIds = $request->input('ids'); // Expecting a comma-separated string of multimedia IDs

        if (!is_string($multimediaIds) || empty($multimediaIds)) {
             return response()->json([
                'success' => false,
                'message' => 'No se proporcionaron IDs de multimedia para exportar.'
            ], 400);
        }

        $idsArray = explode(',', $multimediaIds);
        $idsArray = array_filter($idsArray); // Remove empty strings

        if (empty($idsArray)) {
             return response()->json([
                'success' => false,
                'message' => 'No se proporcionaron IDs de multimedia válidos para exportar.'
            ], 400);
        }

        try {
            $multimedias = Multimedia::whereIn('id', $idsArray)->get();

            if ($multimedias->isEmpty()) {
                 return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron archivos multimedia con los IDs proporcionados.'
                ], 404);
            }

            // Get title and date from the first multimedia item (assuming consistency for the group)
            $titulo = $multimedias->first()->text ?? 'Sin Título';
            $fecha = $multimedias->first()->media_date ? $multimedias->first()->media_date->format('Y-m-d') : 'Sin Fecha';

            // Generate report text content
            $multimediaContent = "Título del Grupo: " . $titulo . "\n";
            $multimediaContent .= "Fecha: " . $fecha . "\n\n";
            $multimediaContent .= "Archivos Incluidos:\n";
            foreach ($multimedias as $media) {
                 $multimediaContent .= "- " . $media->text . '.' . pathinfo($media->path, PATHINFO_EXTENSION) . "\n";
            }

            // Create a temporary file for the multimedia group info
            $textFileName = 'informacion_multimedia.txt';
            $tempTextFilePath = tempnam(sys_get_temp_dir(), 'multimedia_txt_export');
            file_put_contents($tempTextFilePath, $multimediaContent);

            // Create a temporary directory for the zip file
            $zipFileName = 'multimedia_' . now()->format('Ymd_His') . '.zip';
            $tempZipFilePath = tempnam(sys_get_temp_dir(), 'multimedia_zip_export');
            // Delete the temporary file created by tempnam, we only need the name
            unlink($tempZipFilePath);
            $tempZipFilePath .= '.zip'; // Add .zip extension

            $zip = new ZipArchive();

            if ($zip->open($tempZipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                // Add the multimedia info text file to the zip
                $zip->addFile($tempTextFilePath, $textFileName);

                // Add associated media files to the zip
                foreach ($multimedias as $media) {
                    $storagePath = 'public/' . $media->path;
                    if (Storage::exists($storagePath)) {
                        $mediaContent = Storage::get($storagePath);
                        // Use the original file name for the zip entry
                        $zip->addFromString('archivos/' . $media->text . '.' . pathinfo($media->path, PATHINFO_EXTENSION), $mediaContent);
                    } else {
                        // Log or handle missing files
                         // Optionally add a placeholder file in the zip
                         $zip->addFromString('archivos/' . $media->text . '.' . pathinfo($media->path, PATHINFO_EXTENSION) . '.missing', 'Archivo no encontrado');
                    }
                }

                $zip->close();

                // Set appropriate headers for download
                $headers = [
                    'Content-Type' => 'application/zip',
                    'Content-Disposition' => 'attachment; filename="' . $zipFileName . '";',
                    'Content-Length' => filesize($tempZipFilePath),
                ];

                // Return the zip file as a download
                // Delete temporary text file before sending response
                unlink($tempTextFilePath);
                return Response::download($tempZipFilePath, $zipFileName, $headers)->deleteFileAfterSend(true);

            } else {
                 // Clean up temporary text file
                unlink($tempTextFilePath);
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el archivo zip.',
                ], 500);
            }

        } catch (Exception $e) {
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
                'message' => 'Error al exportar los archivos multimedia: ' . $e->getMessage()
            ], 500);
        }
    }
}
