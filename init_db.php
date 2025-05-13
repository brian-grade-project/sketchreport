<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $pdo = new PDO(
        "mysql:host=127.0.0.1;dbname=sketchreport",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "Conexión exitosa a la base de datos\n";
    
    // Eliminar la tabla de migraciones si existe
    $pdo->exec("DROP TABLE IF EXISTS migrations");
    echo "Tabla de migraciones eliminada\n";
    
    // Crear la tabla de migraciones con la estructura correcta
    $pdo->exec("CREATE TABLE migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        batch INT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "Tabla de migraciones creada con la estructura correcta\n";
    
    // Limpiar la caché de la configuración
    $pdo->exec("DROP TABLE IF EXISTS cache");
    echo "Tabla de caché eliminada\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 