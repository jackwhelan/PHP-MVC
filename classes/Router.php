<?php
    namespace classes;

    class Router
    {
        var $route;

        function __construct($url)
        {
            $this->route = new Route($url);
        }
    }
?>