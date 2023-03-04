<?php

namespace Src\Core;

use Src\Core\Http\Request;
use Src\Core\Http\Response;

class Router
{
    private Request $request;
    private array $routes = [];

    public function __construct()
    {
        $this->request = new Request();
    }

    public function get(string $path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $callback = $this->getCallback();

        if ($callback === false) {
            return Response::show404();
        }
        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }
        return call_user_func($callback, $this->request);
    }

    private function getCallback()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        if (isset($this->routes[$method][$path])) {
            return $this->routes[$method][$path];
        }

        $routesWithParams = [];
        foreach ($this->routes[$method] as $route => $callback) {
            if (preg_match_all('/\{(\w+)}/', $route, $routesWithParams[$route]) === 0) {
                unset($routesWithParams[$route]);
            }
        }

        $routesWithParams = array_keys($routesWithParams);
        $routesRegEx = $this->convertRoutesToRegEx($routesWithParams);

        $callback = false;
        $params = [];
        foreach ($routesRegEx as $key => $regEx) {
            if (preg_match($regEx, $path, $params)) {
                $callback = $this->routes[$method][$routesWithParams[$key]];
                array_shift($params);
                $this->request->setParams($params);
                break;
            }
        }

        return $callback;
    }

    private function convertRoutesToRegEx(array $routesWithParams)
    {
        foreach ($routesWithParams as $key => $route) {
            $routesWithParams[$key] = '/^' . preg_replace('/\{number}/', '(\d+)', $this->escapeSlashes($route)) . '$/';
        }
        return $routesWithParams;
    }

    private function escapeSlashes(string $route)
    {
        return str_replace('/', '\/', $route);
    }
}
