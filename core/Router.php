<?php

namespace Core;

class Router
{
    private static array $routes = [];

    public static function get($uri, $action)
    {
        self::$routes['GET'][$uri] = $action;
    }

    public static function post($uri, $action)
    {
        self::$routes['POST'][$uri] = $action;
    }

    public function dispatch($uri, $method)
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        $basePath = '/CoachPro(MVC)/public';
        if (str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        if ($uri === '') {
            $uri = '/';
        }


        if (!isset(self::$routes[$method][$uri])) {
            http_response_code(404);
            echo "404 - Page non trouvée";
            return;
        }

        [$controller, $action] = explode('@', self::$routes[$method][$uri]);
        $controller = "App\\Controllers\\$controller";

        call_user_func([new $controller, $action]);
    }
}
