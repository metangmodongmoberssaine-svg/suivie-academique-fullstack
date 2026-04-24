<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Personnel;
use Illuminate\Support\Facades\Hash;

$login = 'dev+mailtest@example.com';
$password = 'SecretPwd123';

$existing = Personnel::where('login_personnel', $login)->first();
if ($existing) {
    echo "Personnel already exists: {$login}\n";
    exit(0);
}

$pers = Personnel::create([
    'code_personnel' => 'MAILTEST1',
    'nom_personnel' => 'Mail Test',
    'login_personnel' => $login,
    'password_personnel' => Hash::make($password),
    'phone_personnel' => '600000000',
    'sex_personnel' => 'M',
    'type_personnel' => 'ENSEIGNANT'
]);

echo "Created personnel {$login} with password {$password}\n";