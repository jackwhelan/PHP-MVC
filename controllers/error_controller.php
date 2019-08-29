<?php
    namespace controllers;
    use classes\controller;

    class error_controller extends controller
    {
        var $view;
        var $local_view;
        var $default_title;
        var $local_title;

        function __construct($view, $local_view, $default_title, $local_title)
        {
            $this->view = $view;
            $this->local_view = $local_view;
            $this->default_title = $default_title;
            $this->local_title = $local_title;
        }
    }
?>