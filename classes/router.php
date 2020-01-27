<?php
    namespace classes;

    class router
    {
        var $route;

        function __construct($url)
        {
            $this->route = new route($url);
        }
    }
?>
