<?php
    namespace controllers;
    use classes\controller;

    class error_controller extends controller
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

        function printStack($stack)
        {
            $errors = $stack;
            if(file_exists($this->view))
            {
                if(file_exists($this->local_view))
                {
                    $local_view = $this->local_view;
                }
                else
                {
                    $error = "View not found"; // change this to a number corresponding to this error
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
    }
?>