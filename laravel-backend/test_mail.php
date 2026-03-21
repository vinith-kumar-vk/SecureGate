<?php
use Illuminate\Support\Facades\Mail;
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Mail::raw('SMTP Test from SecureGate', function ($message) {
        $message->to('vinithkumar78878@gmail.com')->subject('SMTP Test');
    });
    echo "SUCCESS: Mail sent.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
