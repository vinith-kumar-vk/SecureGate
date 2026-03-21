<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

$user = User::updateOrCreate(
    ['email' => 'superadmin@securegate.com'],
    [
        'name' => 'Super Admin Master',
        'password' => Hash::make('admin123'),
        'role' => 'superadmin',
        'society_id' => 1
    ]
);

echo "Superadmin created: " . $user->email . "\n";
