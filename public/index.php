<?php
declare(strict_types=1);

// Built-in PHP server: let it serve existing static files directly.
if (PHP_SAPI === 'cli-server') {
    $file = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($file)) {
        return false;
    }
}

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Controllers\Admin;
use App\Controllers\BlogController;
use App\Controllers\PageController;
use App\Controllers\QueryController;
use App\Controllers\SeoController;
use App\Controllers\TrackingController;
use App\Core\Router;
use App\Core\Session;

Session::start();

$router = new Router();

// ---- Public site ----
$router->get('/', [PageController::class, 'home']);
$router->get('/about', [PageController::class, 'about']);
$router->get('/services', [PageController::class, 'services']);
$router->get('/services/{slug}', [PageController::class, 'service']);
$router->get('/tracking', [TrackingController::class, 'index']);
$router->get('/quote', [PageController::class, 'quote']);
$router->post('/quote', [QueryController::class, 'quote']);
$router->get('/contact', [PageController::class, 'contact']);
$router->post('/contact', [QueryController::class, 'contact']);
$router->get('/privacy-policy', [PageController::class, 'privacy']);
$router->get('/terms', [PageController::class, 'terms']);
$router->get('/blog', [BlogController::class, 'index']);
$router->get('/blog/category/{slug}', [BlogController::class, 'category']);
$router->get('/blog/{slug}', [BlogController::class, 'show']);
$router->get('/sitemap.xml', [SeoController::class, 'sitemap']);
$router->get('/robots.txt', [SeoController::class, 'robots']);

// ---- Admin ----
$router->get('/admin/login', [Admin\AuthController::class, 'showLogin'], ['guest']);
$router->post('/admin/login', [Admin\AuthController::class, 'login'], ['guest']);
$router->post('/admin/logout', [Admin\AuthController::class, 'logout'], ['auth']);

$router->get('/admin', [Admin\DashboardController::class, 'index'], ['auth']);

$router->get('/admin/posts', [Admin\PostController::class, 'index'], ['auth']);
$router->get('/admin/posts/create', [Admin\PostController::class, 'create'], ['auth']);
$router->post('/admin/posts', [Admin\PostController::class, 'store'], ['auth']);
$router->get('/admin/posts/{id}/edit', [Admin\PostController::class, 'edit'], ['auth']);
$router->post('/admin/posts/{id}', [Admin\PostController::class, 'update'], ['auth']);
$router->post('/admin/posts/{id}/delete', [Admin\PostController::class, 'destroy'], ['auth']);

$router->get('/admin/categories', [Admin\CategoryController::class, 'index'], ['auth']);
$router->post('/admin/categories', [Admin\CategoryController::class, 'store'], ['auth']);
$router->post('/admin/categories/{id}/delete', [Admin\CategoryController::class, 'destroy'], ['auth']);

$router->get('/admin/queries', [Admin\QueryController::class, 'index'], ['auth']);
$router->get('/admin/queries/export', [Admin\QueryController::class, 'export'], ['auth']);
$router->get('/admin/queries/{id}', [Admin\QueryController::class, 'show'], ['auth']);
$router->post('/admin/queries/{id}', [Admin\QueryController::class, 'update'], ['auth']);
$router->post('/admin/queries/{id}/delete', [Admin\QueryController::class, 'destroy'], ['auth']);

$router->get('/admin/shipments', [Admin\ShipmentController::class, 'index'], ['auth']);
$router->post('/admin/shipments', [Admin\ShipmentController::class, 'store'], ['auth']);
$router->get('/admin/shipments/{id}', [Admin\ShipmentController::class, 'show'], ['auth']);
$router->post('/admin/shipments/{id}/events', [Admin\ShipmentController::class, 'addEvent'], ['auth']);
$router->post('/admin/shipments/{id}/delete', [Admin\ShipmentController::class, 'destroy'], ['auth']);

$router->get('/admin/settings', [Admin\SettingController::class, 'index'], ['admin']);
$router->post('/admin/settings', [Admin\SettingController::class, 'update'], ['admin']);

$router->get('/admin/account', [Admin\AuthController::class, 'showAccount'], ['auth']);
$router->post('/admin/account', [Admin\AuthController::class, 'updateAccount'], ['auth']);
$router->post('/admin/users', [Admin\AuthController::class, 'createUser'], ['admin']);

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', current_path());
} catch (\Throwable $e) {
    error_log((string) $e);
    if (config('app.debug')) {
        throw $e;
    }
    abort(500);
}
