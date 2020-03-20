<?php

namespace core;

class Router {

    private $routes;

    public function __construct() {
        $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'routes.php';
        $this->routes = include($path);
    }

    private function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run() {
        $uri = $this->getURI();


        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~^$uriPattern$~", $uri)) {

                $internalRoute = preg_replace("~^$uriPattern$~", $path, $uri);

                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments);
                $modelName = 'Model' . ucfirst($controllerName);
                $controllerName = 'Controller' . ucfirst($controllerName);
                $actionName = 'action' . ucfirst(array_shift($segments));
                $parameters = $segments;


                $controllerFile = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $controllerName . '.php';
                $modelFile = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $modelName . '.php';

                if (file_exists($modelFile)) {
                    include_once($modelFile);
                }

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                $controllerObject = new $controllerName;


                $controllerObject->$actionName($parameters);

//                if ($result != null) {
//
//                    break;
//                }
                $j = 0;
                $j = $j + 1;
            }
        }
        if($j == null){
            echo 'Error 404. Not found!';
        }
    }
}