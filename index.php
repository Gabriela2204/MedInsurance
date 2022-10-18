<?php

namespace index;

$controllerName = $_GET['controller'];
$action = $_GET['action'];
require_once(__DIR__."\Controller\\".$controllerName.'.php');

$class ="Controller\\$controllerName" ;

$controller  = new $class();
$controller->$action(); 


?>