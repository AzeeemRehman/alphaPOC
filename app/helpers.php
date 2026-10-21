<?php
declare(strict_types=1);

use App\Core\Session;
use App\Models\Setting;

function config(string $key, mixed $default = null): mixed
{
    static $config = null;
    $config ??= require ROOT . '/app/config.php';
    $value = $config;
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

/** Escape for HTML output. */
function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Path prefix when the site is served from a sub-folder (e.g. XAMPP htdocs/alpha/public). */
function base_path(): string
{
    static $base = null;
    if ($base === null) {
        $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
        $base = rtrim($dir, '/');
    }
    return $base;
}

function url(string $path = '/', array $query = []): string
{
    $url = base_path() . '/' . ltrim($path, '/');
    if ($query) {
        $url .= '?' . http_build_query($query);
    }
    return $url === '' ? '/' : $url;
}

/** Absolute URL using APP_URL (for emails, sitemap, canonical & OG tags). */
function absolute_url(string $path = '/'): string
{
    return config('app.url') . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    $file = ROOT . '/public/' . ltrim($path, '/');
    $version = is_file($file) ? '?v=' . filemtime($file) : '';
    return url($path) . $version;
}

function upload_url(?string $file): ?string
{
    return $file ? url('uploads/blog/' . $file) : null;
}

function current_path(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $base = base_path();
    if ($base !== '' && str_starts_with($path, $base)) {
        $path = substr($path, strlen($base));
    }
    return '/' . trim($path, '/');
}

/** True when the current path equals (or, with $prefix, starts with) the given path. */
function is_active(string $path, bool $prefix = false): bool
{
    $current = current_path();
    return $prefix ? ($current === $path || str_starts_with($current, rtrim($path, '/') . '/')) : $current === $path;
}

function view(string $template, array $data = [], ?string $layout = 'layouts/main'): string
{
    $render = static function (string $__file, array $__data): string {
        extract($__data, EXTR_SKIP);
        ob_start();
        require ROOT . '/app/views/' . $__file . '.php';
        return (string) ob_get_clean();
    };
    $content = $render($template, $data);
    if ($layout === null) {
        return $content;
    }
    return $render($layout, $data + ['content' => $content]);
}

function partial(string $template, array $data = []): void
{
    echo view($template, $data, null);
}

function redirect(string $path, int $status = 302): never
{
    $location = preg_match('#^https?://#', $path) ? $path : url($path);
    header('Location: ' . $location, true, $status);
    exit;
}

/** Redirect back to the referring page on this site (falls back to $fallback). */
function back(string $fallback = '/'): never
{
    $ref = $_SERVER['HTTP_REFERER'] ?? '';
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if ($ref !== '' && parse_url($ref, PHP_URL_HOST) === $host) {
        header('Location: ' . $ref, true, 302);
        exit;
    }
    redirect($fallback);
}

function abort(int $status = 404): never
{
    http_response_code($status);
    echo view('pages/error', ['status' => $status, 'title' => $status === 404 ? 'Page Not Found' : 'Something went wrong']);
    exit;
}

function input(string $key, mixed $default = null): mixed
{
    $value = $_POST[$key] ?? $_GET[$key] ?? $default;
    return is_string($value) ? trim($value) : $value;
}

function csrf_token(): string
{
    return Session::csrfToken();
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }
    $value = $_SESSION['_flash_now'][$key] ?? null;
    return $value;
}

function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['_old_now'][$key] ?? $default;
}

function error(string $key): ?string
{
    return $_SESSION['_errors_now'][$key] ?? null;
}

function errors(): array
{
    return $_SESSION['_errors_now'] ?? [];
}

/** Redirect back with validation errors and the submitted input. */
function back_with_errors(array $errors, string $fallback = '/'): never
{
    $old = $_POST;
    unset($old['_token'], $old['password'], $old['password_confirmation'], $old['current_password']);
    $_SESSION['_errors'] = $errors;
    $_SESSION['_old'] = $old;
    back($fallback);
}

function setting(string $key, string $default = ''): string
{
    return Setting::get($key, $default);
}

function auth_user(): ?array
{
    return App\Core\Auth::user();
}

function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim((string) $text, '-') ?: 'post';
}

function excerpt(?string $html, int $length = 160): string
{
    $text = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string) $html), ENT_QUOTES, 'UTF-8')));
    return mb_strlen($text) > $length ? rtrim(mb_substr($text, 0, $length)) . '…' : $text;
}

function format_date(?string $date, string $format = 'M j, Y'): string
{
    return $date ? date($format, strtotime($date)) : '';
}

function reading_time(?string $html): int
{
    return max(1, (int) ceil(str_word_count(strip_tags((string) $html)) / 200));
}

function client_ip(): string
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function phone_href(string $phone): string
{
    return 'tel:' . preg_replace('/[^0-9+]/', '', $phone);
}

function whatsapp_link(string $text = ''): string
{
    $number = preg_replace('/\D/', '', setting('whatsapp', '923332209385'));
    return 'https://wa.me/' . $number . ($text !== '' ? '?text=' . rawurlencode($text) : '');
}

function status_badge(string $status): string
{
    $map = [
        'new' => 'bg-orange-100 text-orange-700',
        'in_progress' => 'bg-blue-100 text-blue-700',
        'closed' => 'bg-slate-200 text-slate-600',
        'published' => 'bg-green-100 text-green-700',
        'draft' => 'bg-slate-200 text-slate-600',
    ];
    $class = $map[$status] ?? 'bg-slate-100 text-slate-700';
    return '<span class="badge ' . $class . '">' . e(ucwords(str_replace('_', ' ', $status))) . '</span>';
}
