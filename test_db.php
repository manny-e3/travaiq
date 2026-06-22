<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

try {
    $users = User::all();
    foreach ($users as $u) {
        echo "ID: {$u->id}, Name: {$u->name}, Email: {$u->email}, Verified At: " . ($u->email_verified_at ?? 'NULL') . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
