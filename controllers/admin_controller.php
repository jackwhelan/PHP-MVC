<?php
    namespace controllers;
    use classes\controller;

    class admin_controller extends controller
    {
        var $model;
        var $view;
        var $local_view;
        var $default_title;
        var $local_title;

        function __construct($model, $view, $local_view, $default_title, $local_title)
        {
            $this->model = $model;
            $this->view = $view;
            $this->local_view = $local_view;
            $this->default_title = $default_title;
            $this->local_title = $local_title;
        }

        function renderView()
        {
            $config = json_decode(file_get_contents("config.json"));
            $title = $config->DEFAULT_TITLE;
            $local_view = $config->CONTROLLERS->ADMIN_CONTROLLER->LOCAL_VIEW;
            $local_title = $config->CONTROLLERS->ADMIN_CONTROLLER->LOCAL_TITLE;
            include($config->CONTROLLERS->ADMIN_CONTROLLER->VIEW);
        }

        function portalMessage($message)
        {
            $config = json_decode(file_get_contents("config.json"));
            $title = $config->DEFAULT_TITLE;
            $local_view = $config->CONTROLLERS->ACCOUNT_CONTROLLER->PORTAL_PAGE->VIEW;
            $local_title = $config->CONTROLLERS->ACCOUNT_CONTROLLER->PORTAL_PAGE->TITLE;
            $msg = $message;
            include($config->CONTROLLERS->ACCOUNT_CONTROLLER->VIEW);
        }
    }
?>