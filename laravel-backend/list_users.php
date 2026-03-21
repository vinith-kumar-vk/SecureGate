<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
// Check what columns exist
$cols = DB::select("PRAGMA table_info(users)");
foreach ($cols as $c) {
    echo "Column: {$c->name}\n";
}
echo "\n--- User 1 raw ---\n";
$u = DB::table('users')->where('id', 1)->first();
echo json_encode($u) . "\n";
