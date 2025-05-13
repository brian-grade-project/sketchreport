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
    
    // Crear la tabla de migraciones si no existe
    $pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        batch INT NOT NULL
    )");
    
    echo "Tabla de migraciones creada o ya existente\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 