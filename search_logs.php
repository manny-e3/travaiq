<?php
$logFile = 'storage/logs/laravel.log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    foreach ($lines as $num => $line) {
        if (stripos($line, 'Favorite') !== false) {
            echo "Line " . ($num + 1) . ": " . substr($line, 0, 500) . "...\n";
        }
    }
}
