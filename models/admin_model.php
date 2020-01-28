<?php
    namespace models;

    class admin_model
    {
        function submitPost()
        {
            $config = json_decode(file_get_contents("config.json"));

            if (isset($_POST))
            {
                $TITLE = $_POST['TITLE'];
                $AUTHOR = $_POST['AUTHOR'];
                $CONTENT = $_POST['CONTENT'];

                if (file_exists($config->DB_CONFIG))
                {
                    include($config->DB_CONFIG);

                    if (!($STMT = $CONN->prepare("INSERT INTO NEWS(TITLE, AUTHOR, CONTENT) VALUES (?, ?, ?)")))
                    {
                        $portal_message = ("Prepare failed: (" . $CONN->errno . ") " . $CONN->error);
                        $fail = true;
                    }

                    if (!$STMT->bind_param("sss", $TITLE, $AUTHOR, $CONTENT))
                    {
                        $portal_message = ("Binding parameters failed: (" . $STMT->errno . ") " . $STMT->error);
                        $fail = true;
                    }

                    if (!$STMT->execute())
                    {
                        $portal_message = ("Execute failed: (" . $STMT->errno . ") " . $STMT->error);
                        $fail = true;
                    }

                    if (!$STMT->close())
                    {
                        $portal_message = ("Termination failed: (" . $STMT->errno . ") " . $STMT->error);
                        $fail = true;
                    }
                    
                    if(!$fail)
                    {
                        $portal_message = ("Post added successfully.");
                    }
                }

                return $portal_message;
            }
        }
    }

?>
