<?php
    // Class autoloader
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

    // Creates a router object, which breaks up the URI into Controller/Methods[]
    $router = new CoreClass\Router($_SERVER['REQUEST_URI']);

    // Creating an array object to store an associative array of the controllers
    // specificed in the config file.
    $controllers = array();

    // Looping through the controllers in the config file, creating an instance
    // of each and storing them all in an associative array.
    foreach($config->CONTROLLERS as $ctrl)
    {
        $name = "controllers\\" . $ctrl->NAME . "_Controller";
        $add = new $name($ctrl->VIEW, $ctrl->LOCAL_VIEW);
        $assoc = array($ctrl->NAME => $add);
        $controllers = array_merge($controllers, $assoc);
    }

    // Concatenating _controller.php to the name of the router requested controller.
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

    // Render the selected controller.
    $controller->renderView();

    // For each other URI argument execute it as a method. i.e. 
    // "www.website.com/register/submit" would execute the submit method of the register controller.
    foreach($router->route->methods as $method)
    {
        // Only execute the method if the requested method isn't to render the view!
        if ($method != "renderView")
        {
            ${$router->route->controller . "_Controller"}->$method();
        }
    }
?>