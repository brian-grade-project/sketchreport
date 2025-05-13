<?php

namespace App\Http\Controllers;

use App\Models\Multimedia;
use App\Services\FileTypeHandler;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MultimediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $multimedias = Multimedia::with('media_files')->latest()->paginate(10);
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
            $savedFiles = [];

            foreach ($files as $file) {
                // Procesar el archivo según su tipo
                $handler = new FileTypeHandler($file);
                $result = $handler->process();

                // Crear registro en la base de datos
                $multimedia = Multimedia::create([
                    'report_id' => $request->report_id,
                    'path' => $result['path'],
                    'thumbnail' => $result['thumbnail'] ?? null,
                    'type' => $result['type'],
                    'text' => $request->titulo,
                    'media_date' => $request->media_date,
                    'metadata' => $result['metadata']
                ]);

                $savedFiles[] = $multimedia;
            }

            return redirect()->route('multimedia.index')
                ->with('success', 'Archivos multimedia guardados exitosamente.');

        } catch (Exception $e) {
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
}
