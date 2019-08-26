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
    $controller_filename = $router->route->controller . "_controller.php";

    // If the requested controller exists, select it.
    if(file_exists("controllers/$controller_filename"))
    {
        $controller = $controllers[$router->route->controller];
    } // If the URI does not request a specific controller select the default controller.
    else if ($router->route->controller == "")
    {
        $controller = $controllers[$config->DEFAULT_CONTROLLER];
    } // If the requested controller does not exist, select the error controller.
    else
    {
        $controller = $controllers[$config->ERROR_CONTROLLER];
    }
    $controller->renderView();
?>