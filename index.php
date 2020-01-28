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
    $config = json_decode(file_get_contents("config.json"));

    // Creates a router object, which breaks up the URI into Controller/Methods[]
    $router = new CoreClass\router($_SERVER['REQUEST_URI']);

    // Creating an array object to store an associative array of the controllers
    // specificed in the config file. Also one for models.
    $controllers = array();
    $models = array();

    // An array object to store error messages to return to the user should they occur.
    $stack = array();

    // Looping through the models in the config file, creating an instance
    // of each and storing them all in an associative array.
    foreach($config->MODELS as $model)
    {
        $name = "models\\" . $model->NAME . "_model";
        $add = new $name();
        $assoc = array($model->NAME => $add);
        $models = array_merge($models, $assoc);
    }

    // Looping through the controllers in the config file, creating an instance
    // of each and storing them all in an associative array.
    foreach($config->CONTROLLERS as $ctrl)
    {
        $name = "controllers\\" . $ctrl->NAME . "_controller";
        if (isset($models[$ctrl->NAME]))
        {
            $add = new $name($models[$ctrl->NAME], $ctrl->VIEW, $ctrl->LOCAL_VIEW, $config->DEFAULT_TITLE, $ctrl->LOCAL_TITLE);
        }
        else
        {
            $add = new $name(null, $ctrl->VIEW, $ctrl->LOCAL_VIEW, $config->DEFAULT_TITLE, $ctrl->LOCAL_TITLE);
        }
        $assoc = array($ctrl->NAME => $add);
        $controllers = array_merge($controllers, $assoc);
    }

    // Starting the session
    session_start();

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
        $error = "[404] The page you are trying to access has no controller.";
        array_push($stack, $error);
        $controller = $controllers[$config->ERROR_CONTROLLER];
    }

    // For each other URI argument execute it as a method. i.e. 
    // "www.website.com/register/submit" would execute the submit method of the register controller.
    foreach($router->route->methods as $method)
    {
        // Only execute the method if the requested method isn't to render the view and if it actually exists!
        if(method_exists($controllers[$router->route->controller], $method) && $method != "renderView")
        {
            $controllers[$router->route->controller]->$method();
        }
        else
        {
            $error = "Requested method '$method' does not exist.";
            array_push($stack, $error);
        }
    }

    if (isset($stack[0]))
    {
        $controllers["error"]->printStack($stack);
    }
    else
    {
        $pagesToRender = 0;
        foreach ($config->RENDER_METHODS as $item)
        {
            if ($item == $method)
            {
                $pagesToRender = $pagesToRender + 1;
            }
        }

        if ($pagesToRender < 1)
        {
            $controller->renderView();
        }
    }
    
?>