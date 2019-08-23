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
    
    $router = new CoreClass\Router($_SERVER['REQUEST_URI']);
    $json = json_encode(get_object_vars($router->route));
    echo $json;
?>