<?php
    namespace classes;

    class controller
    {
        var $view;
        var $local_view;

        function __construct($view, $local_view)
        {
            $this->view = $view;
            $this->local_view = $local_view;
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
                    $error = "View not found"; // change this to a number corresponding to this error
                    $this->local_view = "views/error.phtml";
                }
                include($this->view);
            }
            else
            {
                return "The view for $this could not be found.";
            }
        }
    }
?>