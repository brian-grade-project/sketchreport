<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP está funcionando correctamente\n";
echo "Versión de PHP: " . phpversion() . "\n";
echo "Extensiones cargadas:\n";
print_r(get_loaded_extensions()); 