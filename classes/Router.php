<?php
    namespace classes;

    class Router
    {
        var $route;

        function __construct()
        {
            $this->route = [];
        }

        function createRoute($url)
        {
            $newRoute = new Route($url);
            array_push($this->route, $newRoute);
        }
    }
?>