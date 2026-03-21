<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'admin@securegate.com';
$password = 'admin123';

$user = User::where('email', $email)->first();
if (!$user) {
    $user = User::create([
        'name' => 'System Admin',
        'email' => $email,
        'password' => Hash::make($password),
        'role' => 'admin',
        'society_id' => 1, // Assuming society 1 exists
    ]);
    echo "Created admin user: {$email} with password: {$password}\n";
} else {
    $user->password = Hash::make($password);
    $user->role = 'admin';
    $user->save();
    echo "Updated admin user: {$email} with password: {$password}\n";
}
