<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

try {
    // Crear usuario de prueba
    $user = User::create([
        'name' => 'Admin',
        'lastname' => 'Test',
        'username' => 'admin',
        'email' => 'admin@test.com',
        'password' => Hash::make('password123')
    ]);

    echo "Usuario creado exitosamente:\n";
    echo "Email: admin@test.com\n";
    echo "Contraseña: password123\n";
} catch (\Exception $e) {
    echo "Error al crear el usuario: " . $e->getMessage() . "\n";
} 