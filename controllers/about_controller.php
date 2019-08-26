<?php
    namespace controllers;

    class about_controller
    {
        var $view;

        function __construct($view)
        {
            $this->view = $view;
        }

        function renderView()
        {
            if(file_exists($this->view))
            {
                include($this->view);
            }
            else
            {
                return "The view for $this could not be found.";
            }
        }
    }
?>