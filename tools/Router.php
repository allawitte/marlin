<?php

/**
 * Created by PhpStorm.
 * User: HP
 * Date: 7/27/2019
 * Time: 7:25 PM
 */
class Router
{
    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function getRoute($route)
    {
        if ($this->checkRoutes($route)) {
            return $this->routes[$route];
        }
        $path = $this->checkRoutesWithId($route);
        if ($path) {
            return $path;
        }
        else {
            console('404');
        }
    }

    private function checkRoutes($route)
    {
        if (array_key_exists($route, $this->routes)) {
            if (gettype($this->routes[$route]) == 'string') return true;
        }
        return false;
    }

    private function checkRoutesWithId($route)
    {
        function filterPathWithId($path)
        {
            return (substr($path, -5) == '{/id}');
        }

        $keys = array_keys($this->routes);
        $keys = array_filter($keys, "filterPathWithId");
        foreach ($keys as $key) {
            $reg = $this->stringToRegular($key);
            preg_match('#' . $reg . '#', $route, $matches);
            //var_dump($matches);
            if (count($matches) === 1) {
                $this->makePathWithId($route, $key);
                return $this->routes[$key];
            }
        }
        return false;
    }

    private function stringToRegular($path)
    {
        return str_replace('{/id}', '/+\d+', $path);
    }

    private function makePathWithId($route, $key)
    {
        $pathParts = explode('/', $route);
        $id = array_pop($pathParts);
        $_GET['id'] = $id;

    }

}