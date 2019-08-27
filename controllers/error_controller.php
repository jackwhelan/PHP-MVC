<?php
    namespace controllers;
    use classes\controller;

    class error_controller extends controller
    {
        var $view;
        var $local_view;

        function __construct($view, $local_view)
        {
            $this->view = $view;
            $this->view = $local_view;
        }
    }
?>