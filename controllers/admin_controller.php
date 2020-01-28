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
            if (!isset($_SESSION['USER']))
            {
                if(file_exists($this->view))
                {
                    if(file_exists($this->local_view))
                    {
                        $local_view = $this->local_view;
                    }
                    else
                    {
                        $stack = array();
                        $error = "View not found";
                        array_push($stack, $error);
                        $this->local_view = "views/error.phtml";
                    }

                    $title = $this->default_title;
                    $local_title = $this->local_title;
                    require_once($this->view);
                }
                else
                {
                    return "The view for $this could not be found.";
                }
            }
            else
            {
                $this->portalMessage("Welcome to the account portal, " . $_SESSION['USER']->first_name . ".");
            }
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