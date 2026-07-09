<?php

declare(strict_types=1);

namespace App\Config;

use App\Config\Request;

class Router
{
    private array $routes = [];

    public function get(string $uri, string $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, string $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    private function addRoute(string $method, string $uri, string $action): void
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $uri);
        $this->routes[] = [
            'method'  => $method,
            'pattern' => '#^' . $pattern . '$#',
            'action'  => $action,
        ];
    }

    public function route(Request $request): void
    {
        $method = $request->method();
        $uri    = $request->uri();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            if (!preg_match($route['pattern'], $uri, $matches)) {
                continue;
            }
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            [$controllerName, $methodName] = explode('@', $route['action']);
            $class = 'App\\Controllers\\' . str_replace('/', '\\', $controllerName);

            if (!class_exists($class)) {
                throw new \RuntimeException("Controller inexistant: {$class}");
            }
            $controller = $class::getInstance();

            if (!method_exists($controller, $methodName)) {
                throw new \RuntimeException("Method {$methodName} n'existe pas dans {$class}");
            }

            $args = array_map(
                fn($v) => is_numeric($v) ? (int) $v : $v,
                array_values($params)
            );

            $controller->$methodName(...$args);
            return;
        }
        http_response_code(404);
        echo "Page not found";
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
