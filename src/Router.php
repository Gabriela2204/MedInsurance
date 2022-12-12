<?php
namespace App;

class Router
{
    public string $controller;
    public string $action;

    public function __construct()
    {
        $this->controller = $_GET['controller'];
        $this->action = $_GET['action'];
    }
    public function router()
    {
        $class ="App\\Controller\\$this->controller" ; 
        $controllerRouter  = new $class();
        $actiune = $this->action; 
        $controllerRouter->$actiune(); 
    }
}

?>