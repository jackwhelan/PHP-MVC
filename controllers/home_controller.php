<?php
    namespace controllers;
    use classes\controller;

    class home_controller extends controller
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

                if (file_exists($config->DB_CONFIG))
                {
                    $news = $this->model->getLatest();
                }
                
                $title = $this->default_title;
                $local_title = $this->local_title;
                include($this->view);
            }
            else
            {
                return "The view for $this could not be found.";
            }
        }
    }
?>