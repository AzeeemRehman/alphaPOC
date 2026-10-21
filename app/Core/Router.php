<?php
declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];

    public function get(string $path, array $handler, array $middleware = []): void
    {
        $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, array $handler, array $middleware = []): void
    {
        $this->add('POST', $path, $handler, $middleware);
    }

    private function add(string $method, string $path, array $handler, array $middleware): void
    {
        $pattern = preg_replace_callback('/\{(\w+)\}/', function ($m) {
            return match ($m[1]) {
                'id'    => '(?P<id>\d+)',
                'slug'  => '(?P<slug>[a-z0-9-]+)',
                default => '(?P<' . $m[1] . '>[^/]+)',
            };
        }, rtrim($path, '/') ?: '/');

        $this->routes[] = [$method, '#^' . $pattern . '$#', $handler, $middleware];
    }

    public function dispatch(string $method, string $path): void
    {
        $path = rtrim($path, '/') ?: '/';
        $methodAllowed = false;

        foreach ($this->routes as [$routeMethod, $pattern, $handler, $middleware]) {
            if (!preg_match($pattern, $path, $matches)) {
                continue;
            }
            if ($routeMethod !== $method) {
                $methodAllowed = true;
                continue;
            }

            if ($method === 'POST' && !Session::verifyCsrf($_POST['_token'] ?? null)) {
                http_response_code(419);
                echo view('pages/error', ['status' => 419, 'title' => 'Page Expired']);
                return;
            }

            foreach ($middleware as $mw) {
                match ($mw) {
                    'auth'  => Auth::requireLogin(),
                    'admin' => Auth::requireRole('admin'),
                    'guest' => Auth::check() ? redirect('/admin') : null,
                };
            }

            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            [$class, $action] = $handler;
            $response = (new $class())->$action(...array_values($params));
            if (is_string($response)) {
                echo $response;
            }
            return;
        }

        abort($methodAllowed ? 405 : 404);
    }
}
