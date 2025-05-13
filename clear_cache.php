<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Limpiando archivos de caché...\n";

$paths = [
    'bootstrap/cache/*.php',
    'storage/framework/cache/*',
    'storage/framework/views/*',
    'storage/framework/sessions/*'
];

foreach ($paths as $path) {
    $files = glob($path);
    if ($files) {
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
                echo "Eliminado: $file\n";
            }
        }
    }
}

echo "Caché limpiada.\n"; 