<?php

declare(strict_types=1);

namespace App;

use App\Exception\RouteNotFoundException;

class Router
{
    private array $routes = [];

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;
        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register("get", $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register("post", $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function path(): string
    {
        $path = $this->getURL();
        return str_contains($path,'?') ? explode('?', $path)[0] : $path;
    }

    private function getURL()
    {
        $url = $_GET['url'] ?? "home";
        return  filter_var(trim($url,"/"),FILTER_SANITIZE_URL);
    }

    /**
     * @throws RouteNotFoundException
     */
    public function resolve(string $requestUri, string $requestMethod)
    {
        /*echo "<pre>";
        var_dump($this->path(), $this->method());
        exit();*/
        //$route = explode("?", $requestUri)[0];

        $action = $this->routes[$requestMethod][$requestUri] ?? null;

        if(! $action) throw new RouteNotFoundException();

        if(is_callable($action)) {
            return call_user_func($action);
        }

        if(is_array($action)) {
            [$class, $method] = $action;
            if(class_exists($class)) {
                $class = new $class();
                if(method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }
        throw new RouteNotFoundException();
    }

}

