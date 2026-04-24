<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test email from CLI', function ($message) {
        $message->to(config('mail.from.address'))
                ->subject('Direct test mail');
    });
    echo "Mail sent to " . config('mail.from.address') . "\n";
} catch (\Throwable $e) {
    echo "Mail send failed: " . $e->getMessage() . "\n";
}
