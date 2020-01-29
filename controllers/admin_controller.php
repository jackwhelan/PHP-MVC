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
            if ($_SESSION['USER']->clearance == "admin")
            {
                $config = json_decode(file_get_contents("config.json"));
                $title = $config->DEFAULT_TITLE;
                $local_view = $config->CONTROLLERS->ADMIN_CONTROLLER->LOCAL_VIEW;
                $local_title = $config->CONTROLLERS->ADMIN_CONTROLLER->LOCAL_TITLE;
                $msg = "Welcome to the ACP, " . $_SESSION['USER']->first_name . ".";
                include($config->CONTROLLERS->ADMIN_CONTROLLER->VIEW);
            }
            else
            {
                $stack = array();
                $error = "Permission Denied.";
                array_push($stack, $error);
                $local_view = $config->CONTROLLERS->ERROR_CONTROLLER->LOCAL_VIEW;
                include($config->CONTROLLERS->ERROR_CONTROLLER->VIEW);
            }
        }

        function author()
        {
            if ($_SESSION['USER']->clearance == "admin")
            {
                $config = json_decode(file_get_contents("config.json"));
                $title = $config->DEFAULT_TITLE;
                $local_view = $config->CONTROLLERS->ADMIN_CONTROLLER->AUTHOR_PAGE->VIEW;
                $local_title = $config->CONTROLLERS->ADMIN_CONTROLLER->AUTHOR_PAGE->TITLE;
                $msg = "Welcome to the Author page, " . $_SESSION['USER']->first_name . ".";
                include($config->CONTROLLERS->ADMIN_CONTROLLER->VIEW);
            }
            else
            {
                $stack = array();
                $error = "Permission Denied.";
                array_push($stack, $error);
                $local_view = $config->CONTROLLERS->ERROR_CONTROLLER->LOCAL_VIEW;
                include($config->CONTROLLERS->ERROR_CONTROLLER->VIEW);
            }
        }

        function submitPost()
        {
            $portal_message = $this->model->submitPost();
            $this->portalMessage($portal_message);
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