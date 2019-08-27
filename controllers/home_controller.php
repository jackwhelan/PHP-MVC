<?php
    namespace controllers;
    use classes\controller;

    class home_controller extends controller
    {
        var $view;
        var $local_view;

        function __construct($view, $local_view)
        {
            $this->view = $view;
            $this->local_view = $local_view;
        }
    }
?>