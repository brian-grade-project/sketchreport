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
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 