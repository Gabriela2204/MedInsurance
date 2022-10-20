<?php

namespace index;
require_once "vendor/autoload.php";


$controllerName = $_GET['controller'];
$action = $_GET['action'];
$class ="App\\Controller\\$controllerName" ;

$controller  = new $class();
$controller->$action(); 


?>