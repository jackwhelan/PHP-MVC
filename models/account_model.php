<?php
    namespace models;
    use classes as CoreClass;

    class account_model
    {
        function submitRegistration()
        {
            $config = json_decode(file_get_contents("config.json"));

            if (isset($_POST))
            {
                $FIRST_NAME = $_POST['FIRST_NAME'];
                $LAST_NAME = $_POST['LAST_NAME'];
                $USERNAME = $_POST['USERNAME'];
                $PASSWORD = password_hash($_POST['PASSWORD'], PASSWORD_DEFAULT);

                if (file_exists($config->DB_CONFIG))
                {
                    include($config->DB_CONFIG);

                    if (!($STMT = $CONN->prepare("INSERT INTO USER(FIRST_NAME, LAST_NAME, USERNAME, PASSWORD) VALUES (?, ?, ?, ?)")))
                    {
                        $portal_message = ("Prepare failed: (" . $CONN->errno . ") " . $CONN->error);
                        $fail = true;
                    }

                    if (!$STMT->bind_param("ssss", $FIRST_NAME, $LAST_NAME, $USERNAME, $PASSWORD))
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
                        $portal_message = ("Success");
                    }
                }

                return $portal_message;
            }
        }

        function submitLogin()
        {
            $config = json_decode(file_get_contents("config.json"));
            
            if (isset($_POST))
            {
                $USERNAME = $_POST['USERNAME'];
                $PASSWORD = $_POST['PASSWORD'];

                # Retrieve password hash to verify password.
                if (file_exists($config->DB_CONFIG))
                {
                    include($config->DB_CONFIG);

                    # Stores whether or not there has been an error.
                    $hadError = false;

                    if (!($STMT = $CONN->prepare("SELECT USERNAME,PASSWORD FROM USER WHERE USERNAME = ?")))
                    {
                        $portal_message = ("Prepare failed: (" . $CONN->errno . ") " . $CONN->error);
                        $hadError = true;
                    }

                    if (!$STMT->bind_param("s", $USERNAME))
                    {
                        $portal_message = ("Binding parameters failed: (" . $STMT->errno . ") " . $STMT->error);
                        $hadError = true;
                    }

                    if (!$STMT->execute())
                    {
                        $portal_message = ("Execute failed: (" . $STMT->errno . ") " . $STMT->error);
                        $hadError = true;
                    }

                    if (!$STMT->bind_result($USERNAME, $HASH))
                    {
                        echo "Failed to bind result";
                    }

                    while($STMT->fetch())
                    {
                        if(password_verify($PASSWORD, $HASH))
                        {
                            $passwordVerified = true;
                        }
                        else
                        {
                            $passwordVerified = false;
                        }
                    }

                    # Fetching user data and creating a session user object if the password is verified.
                    if ($passwordVerified)
                    {
                        $STMT = $CONN->prepare("SELECT ID,FIRST_NAME,LAST_NAME,USERNAME,PASSWORD,CLEARANCE FROM USER WHERE USERNAME = ?");
                        $STMT->bind_param("s", $USERNAME);
                        $STMT->execute();
                        $STMT->bind_result($ID,$FIRST_NAME,$LAST_NAME,$USERNAME,$PASSWORD,$CLEARANCE);

                        while ($STMT->fetch())
                        {
                            $userObject = new CoreClass\user($ID,$FIRST_NAME,$LAST_NAME,$USERNAME,$PASSWORD,$CLEARANCE);
                        }
                    }

                    if (!$STMT->close())
                    {
                        $portal_message = ("Termination failed: (" . $STMT->errno . ") " . $STMT->error);
                        $hadError = true;
                    }
                }
                
                return $userObject;
            }
        }
    }
?>