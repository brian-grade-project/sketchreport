<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Multimedia;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function performSearch(Request $request)
    {
        try {
            $searchTerm = $request->input('search');

            if (!$searchTerm) {
                return response()->json(['message' => 'Por favor, ingrese un término de búsqueda.'], 400);
            }

            // Realizar búsquedas con logging
            $reports = Report::where('title', 'LIKE', '%' . $searchTerm . '%')->get();
            $multimedia = Multimedia::where('text', 'LIKE', '%' . $searchTerm . '%')->get();

            Log::info('Búsqueda realizada', [
                'término' => $searchTerm,
                'reportes_encontrados' => $reports->count(),
                'multimedia_encontrada' => $multimedia->count()
            ]);

            $reportCount = $reports->count();
            $multimediaCount = $multimedia->count();

            if ($reportCount > 0 && $multimediaCount > 0) {
                // Coincidencia en ambos tipos de elementos
                return response()->json([
                    'message' => 'La búsqueda encontró similitud en consultas.',
                    'type' => 'ambiguous',
                    'redirect' => route('reporte.index', ['search' => $searchTerm])
                ]);
            } elseif ($reportCount > 0) {
                // Coincidencia solo en reportes
                if ($reportCount === 1) {
                    return response()->json([
                        'message' => 'Reporte encontrado.',
                        'type' => 'report',
                        'redirect' => route('reporte.index', ['search' => $searchTerm])
                    ]);
                } else {
                    // Múltiples reportes coinciden
                    return response()->json([
                        'message' => 'Múltiples reportes coinciden con su búsqueda. Mostrando resultados filtrados.',
                        'type' => 'report',
                        'redirect' => route('reporte.index', ['search' => $searchTerm])
                    ]);
                }
            } elseif ($multimediaCount > 0) {
                // Coincidencia solo en multimedia
                if ($multimediaCount === 1) {
                    return response()->json([
                        'message' => 'Archivo multimedia encontrado.',
                        'type' => 'multimedia',
                        'redirect' => route('multimedia.index', ['search' => $searchTerm])
                    ]);
                } else {
                    // Múltiples archivos multimedia coinciden
                    return response()->json([
                        'message' => 'Múltiples archivos multimedia coinciden con su búsqueda. Mostrando resultados filtrados.',
                        'type' => 'multimedia',
                        'redirect' => route('multimedia.index', ['search' => $searchTerm])
                    ]);
                }
            } else {
                // No se encontraron coincidencias
                return response()->json([
                    'message' => 'No se encontró ningún elemento con ese nombre.',
                    'type' => 'not_found'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error en la búsqueda: ' . $e->getMessage(), [
                'término' => $searchTerm ?? 'no definido',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Ocurrió un error durante la búsqueda. Por favor, intente nuevamente.',
                'type' => 'error'
            ], 500);
        }
    }
}
