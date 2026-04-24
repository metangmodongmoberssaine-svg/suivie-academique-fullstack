<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Personnel;
$login = $argv[1] ?? 'dev+mailtest@example.com';
$p = Personnel::where('login_personnel', $login)->first();
if (!$p) {
    echo "Not found: $login\n";
    exit(1);
}
echo json_encode(['login' => $p->login_personnel, 'password_hash' => $p->password_personnel], JSON_PRETTY_PRINT) . "\n";
