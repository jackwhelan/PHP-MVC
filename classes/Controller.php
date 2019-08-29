<?php
    namespace classes;

    class controller
    {
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