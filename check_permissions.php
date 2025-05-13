<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$critical_paths = [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    '.env'
];

foreach ($critical_paths as $path) {
    if (file_exists($path)) {
        echo "$path: " . (is_writable($path) ? "WRITABLE" : "NOT WRITABLE") . "\n";
    } else {
        echo "$path: DOES NOT EXIST\n";
    }
} 