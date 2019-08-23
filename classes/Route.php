<?php
    namespace classes;

    class Route
    {
        var $components;

        function __construct($url)
        {
            $this->components = explode('/', $url);
            array_shift($this->components);
        }

        function getComponents()
        {
            return $this->components;
        }
    }
?>