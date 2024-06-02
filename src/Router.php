<?php

namespace Maoshu\Engine;

class Router extends EngineCore
{
    private $routes = [
        "GET" => [],
        "POST" => [],
        "PUT" => [],
        "DELETE" => []
    ];

    public function addRoute($method, $path, $handler)
    {
        $this->routes[strtoupper($method)][$path] = $handler;
    }

    public function dispatch($method, $path)
    {
        $method = strtoupper($method);
        if (isset($this->routes[$method][$path])) {
            [$class, $method] = $this->routes[$method][$path];
            $controller = new $class();
            return call_user_func([$controller, $method]);
        }

        http_response_code(404);
        echo '404 Not Found';
        return null;
    }
}
