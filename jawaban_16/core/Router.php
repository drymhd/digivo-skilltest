<?php

namespace Core;

class Router
{
    protected $routes = [];

    public function get($route, $action)
    {
        $this->addRoute('GET', $route, $action);
    }

    public function post($route, $action)
    {
        $this->addRoute('POST', $route, $action);
    }

    protected function addRoute($method, $route, $action)
    {
        $this->routes[$method][$route] = $action;
    }

    public function dispatch($method, $uri)
    {
        foreach ($this->routes[$method] as $route => $action) {
            $pattern = "@^" . preg_replace('/{[^}]+}/', '([^/]+)', $route) . "$@";
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                return $this->callAction($action, $matches);
            }
        }
        throw new \Exception("404 Not Found", 404);
    }

    protected function callAction($action, $params)
    {
        list($controller, $method) = explode('@', $action);
        $controller = "App\\Controllers\\$controller";
        if (!class_exists($controller) || !method_exists($controller, $method)) {
            throw new \Exception("404 Not Found", 404);
        }
        $controller = new $controller;
        return call_user_func_array([$controller, $method], $params);
    }
}
