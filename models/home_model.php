<?php
    namespace models;

    class home_model
    {
        function getLatest()
        {
            $config = json_decode(file_get_contents("config.json"));

            include($config->DB_CONFIG);

            $query = "SELECT * FROM NEWS";

            if ($result = $CONN->query($query))
            {
                $articles = array();

                while ($row = $result->fetch_assoc())
                {
                    array_push($articles, $row);
                }

                $result->free();
            }

            $CONN->close();

            return $articles;
        }
    }
?>