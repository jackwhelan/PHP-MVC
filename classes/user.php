<?php
    namespace classes;

    class user
    {
		var $id;
        var $first_name;
		var $last_name;
		var $username;
		var $password;
		var $clearance;

        function __construct($id, $first_name, $last_name, $username, $password, $clearance)
        {
			$this->id = $id;
            $this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->username = $username;
			$this->password = $password;
			$this->clearance = $clearance;
        }
		
		function dump()
		{
			var_dump($this);
		}
    }
?>
