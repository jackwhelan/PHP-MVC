<?php
    spl_autoload_register(function($className) {
        $ds = DIRECTORY_SEPARATOR;
        $dir = __DIR__;
        $className = str_replace('\\', $ds, $className);
        $file = "{$dir}{$ds}{$className}.php";
        
        if(is_readable($file)) {
            require_once $file;
        }
    });

    use classes as CoreClass;
    
    // Importing config.json from config folder. This config file contains
    // the instantiation arguments for controllers and models.
    $config = json_decode(file_get_contents("config/config.json"));

    $router = new CoreClass\Router($_SERVER['REQUEST_URI']);
    $controllers = array();
    foreach($config->CONTROLLERS as $ctrl)
    {
        $name = "controllers\\" . $ctrl->NAME . "_Controller";
        $add = new $name($ctrl->VIEW);
        $assoc = array($ctrl->NAME => $add);
        $controllers = array_merge($controllers, $assoc);
    }
?>