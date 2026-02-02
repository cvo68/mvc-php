<?php 

namespace core;

use app\classes\Uri;
use app\exceptions\ControllerNotExistException;

class Controller{

    private $uri;
    private $controller;
    private $namespace;
    private $folders = [
        'app\controllers\portal',
        'app\controllers\admin',

    ];

    public function __construct(){

        $this->uri = Uri::uri();
    }

    public function load(){
        if($this->isHome()){
            return $this->controllerHome();
        }

        return $this->controllerNotHome();
    }

    private function controllerHome(){
        if($this->controllerExist('HomeController')){
            throw new ControllerNotExistException("Esse controller não existe.");
        }

        return $this->InstanciateController();
    }

    private function controllerNotHome(){
        $controller = $this->getControllerNotHome();

        if ($this->controllerExist($controller)){
            throw new ControllerNotExistException("Esse controller não existe.");
        }

        return $this->InstanciateController();
    }

    private function isHome(){
        return ($this->uri =='/');
    }

    private function getControllerNotHome(){
        if(substr_count($this->uri, '/') > 1){
            list($controller) = explode('/', $this->uri);
            return ucfirst($controller). 'Controller';
        }

        return ucfirst(ltrim($this->uri, '/')).'Controller';
    }

    private function controllerExist($controller){
        $controllerExist = false;

        foreach ($this-> folders as $folder){
            if (class_exists($folder.'\\'.$controller)){
                $controllerExist = true;
                $this->namespace = $folder;
                $this->controller = $controller;
            }
        }

        return $controllerExist;

    }

    private function InstanciateController(){
        $controller = $this->namespace.'\\'.$this->controller;

        return new $controller;
    }
}
?>