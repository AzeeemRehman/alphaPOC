<?php
use App\Core\Env;

return [
    'app' => [
        'name'  => Env::get('APP_NAME', 'ALPHA Global Shipping & Logistics'),
        'env'   => Env::get('APP_ENV', 'production'),
        'debug' => Env::bool('APP_DEBUG', false),
        'url'   => rtrim(Env::get('APP_URL', 'http://localhost:8000'), '/'),
    ],
    'db' => [
        'host'     => Env::get('DB_HOST', '127.0.0.1'),
        'port'     => Env::get('DB_PORT', '3306'),
        'database' => Env::get('DB_DATABASE', 'alpha_gsl'),
        'username' => Env::get('DB_USERNAME', 'root'),
        'password' => Env::get('DB_PASSWORD', ''),
    ],
    'mail' => [
        'driver'     => Env::get('MAIL_DRIVER', 'log'),
        'host'       => Env::get('MAIL_HOST', ''),
        'port'       => (int) Env::get('MAIL_PORT', '465'),
        'encryption' => Env::get('MAIL_ENCRYPTION', 'ssl'),
        'username'   => Env::get('MAIL_USERNAME', ''),
        'password'   => Env::get('MAIL_PASSWORD', ''),
        'from'       => Env::get('MAIL_FROM_ADDRESS', 'no-reply@alphagsl.com'),
        'from_name'  => Env::get('MAIL_FROM_NAME', 'ALPHA Global Shipping'),
    ],
    'turnstile' => [
        'site_key'   => Env::get('TURNSTILE_SITE_KEY', ''),
        'secret_key' => Env::get('TURNSTILE_SECRET_KEY', ''),
    ],
    'uploads' => [
        'max_bytes' => 2 * 1024 * 1024,
        'types'     => ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'],
    ],
    'blog' => ['per_page' => 9],
    'forms' => ['max_per_hour' => 5],
];
