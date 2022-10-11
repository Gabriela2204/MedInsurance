<?php


namespace index;
require_once 'autoloader.php';
use Controller\Insurance as Insurance;


$controllerName = $_GET['controller'];
$action = $_GET['action'];


// $controller  = new $controllerName();
// $controller->$action(); 
if($controllerName == "Insurance")
{
    $controller = new Insurance();
    $controller -> $action();
}



?>