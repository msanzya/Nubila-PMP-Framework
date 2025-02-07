<?php

namespace Nubila\Core;

class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch(Request $request)
    {
        $method = $request->getMethod();
        $path = $request->getPath();

        foreach ($this->routes[$method] as $route => $callback) {
            if ($route === $path) {
                return call_user_func($callback);
            }

            // Handle dynamic routes (e.g., /hello/{name})
            $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
            if (preg_match("#^$pattern$#", $path, $matches)) {
                return call_user_func($callback, $matches[1]);
            }
        }

        return "404 - Page Not Found";
    }
}