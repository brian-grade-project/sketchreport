<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            // Obtener el ID del usuario admin
            $adminId = DB::table('users')
                ->where('email', 'admin@test.com')
                ->value('id');

            Log::info('ID del usuario admin:', ['admin_id' => $adminId]);

            if ($adminId) {
                // Contar registros antes de la actualización
                $countBefore = DB::table('multimedias')->count();
                Log::info('Registros multimedia antes de la actualización:', ['count' => $countBefore]);

                // Actualizar todos los registros multimedia existentes con el ID del admin
                $updated = DB::table('multimedias')
                    ->whereNull('user_id')
                    ->update(['user_id' => $adminId]);

                Log::info('Registros actualizados:', ['updated' => $updated]);

                // Verificar registros después de la actualización
                $countAfter = DB::table('multimedias')->where('user_id', $adminId)->count();
                Log::info('Registros multimedia del admin después de la actualización:', ['count' => $countAfter]);
            } else {
                Log::error('No se encontró el usuario admin');
            }
        } catch (\Exception $e) {
            Log::error('Error en la migración:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No es necesario revertir esta migración ya que es una actualización de datos
    }
};
