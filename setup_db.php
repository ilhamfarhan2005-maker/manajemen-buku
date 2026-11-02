<?php
/**
 * Skrip bantu (dijalankan oleh setup.bat / lanjut.bat, tidak dipakai aplikasi):
 *  1) mengarahkan .env ke MySQL Laragon (user root, tanpa password)
 *  2) membuat database "manajemen_buku" (aplikasi) dan "manajemen_buku_test" (untuk php artisan test)
 */

$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    fwrite(STDERR, "File .env tidak ditemukan di " . __DIR__ . PHP_EOL);
    exit(1);
}

$content = file_get_contents($envFile);

$values = [
    'APP_NAME'      => '"Manajemen Buku"',
    'DB_CONNECTION' => 'mysql',
    'DB_HOST'       => '127.0.0.1',
    'DB_PORT'       => '3306',
    'DB_DATABASE'   => 'manajemen_buku',
    'DB_USERNAME'   => 'root',
    'DB_PASSWORD'   => '',
];

foreach ($values as $key => $value) {
    $pattern = '/^[ \t]*#?[ \t]*' . preg_quote($key, '/') . '=.*$/m';
    $line = $key . '=' . $value;

    if (preg_match($pattern, $content)) {
        $content = preg_replace($pattern, $line, $content, 1);
    } else {
        $content .= PHP_EOL . $line;
    }
}

file_put_contents($envFile, $content);
echo ".env diarahkan ke MySQL (database: manajemen_buku)" . PHP_EOL;

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach (['manajemen_buku', 'manajemen_buku_test'] as $db) {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Database siap: $db" . PHP_EOL;
    }
} catch (Throwable $e) {
    fwrite(STDERR, PHP_EOL . "GAGAL terhubung ke MySQL: " . $e->getMessage() . PHP_EOL);
    fwrite(STDERR, "Pastikan Laragon sudah diklik 'Start All' (MySQL berwarna hijau), lalu jalankan lagi." . PHP_EOL);
    exit(1);
}
