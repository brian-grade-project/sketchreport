<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Iniciando script...\n";

try {
    echo "Cargando autoload.php...\n";
    require __DIR__.'/vendor/autoload.php';
    
    echo "Cargando app.php...\n";
    $app = require_once __DIR__.'/bootstrap/app.php';
    
    echo "Creando kernel...\n";
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    echo "Ejecutando migraciones...\n";
    $status = $kernel->handle(
        $input = new Symfony\Component\Console\Input\ArgvInput(['artisan', 'migrate', '--force']),
        new Symfony\Component\Console\Output\ConsoleOutput()
    );
    
    echo "Script completado.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
} 