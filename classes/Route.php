<?php
    namespace classes;

    class Route
    {
        var $controller;
        var $methods = array();

        function __construct($uri)
        {
            // Stores the URI arguments in an array called components.
            $components = explode('/', $uri);

            // Remove the first item of the array, because it is empty by default.
            array_shift($components);

            // Remove the next item of the array (the first argument of the URI) and store it in the controller field of the Route object.
            $this->controller = array_shift($components);

            // Add each other URI argument to the methods array.
            foreach($components as $method)
            {
                array_push($this->methods, $method);
            }

            // Cleanup
            unset($components);
        }
    }
?>