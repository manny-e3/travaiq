<?php
$logFile = 'storage/logs/laravel.log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $last_lines = array_slice($lines, -50);
    foreach ($last_lines as $line) {
        echo substr($line, 0, 1000) . "\n";
    }
}
