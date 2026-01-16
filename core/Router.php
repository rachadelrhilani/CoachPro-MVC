<?php

namespace Core;

class Router
{
    private static array $routes = [];

    public static function get($uri, $action)
    {
        self::$routes['GET'][] = [
            'uri' => trim($uri, '/'),
            'action' => $action
        ];
    }

    public static function post($uri, $action)
    {
        self::$routes['POST'][] = [
            'uri' => trim($uri, '/'),
            'action' => $action
        ];
    }

    public function dispatch($uri, $method)
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        $basePath = '/CoachPro(MVC)/public';
        if (str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        $uri = trim($uri, '/');

        foreach (self::$routes[$method] ?? [] as $route) {

            // 🔹 transformer {id} en regex
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route['uri']);
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $uri, $matches)) {

                array_shift($matches); // enlever l’URL complète

                [$controller, $action] = explode('@', $route['action']);
                $controller = "App\\Controllers\\$controller";

                call_user_func_array(
                    [new $controller, $action],
                    $matches
                );
                return;
            }
        }

        // ❌ 404
        http_response_code(404);
        echo "404 - Page non trouvée";
    }
}
