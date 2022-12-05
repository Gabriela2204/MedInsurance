<?php

namespace App\Controller;

use App\Request as Request;
use App\Session;
use  App\Configuration;

class BaseController{

 public Request $request;
 public Session $session;

 public function __construct()
 {
   $this->request = new Request();
   $this->session = new Session();
 }

 protected function verifySession()
 {
  $config = new Configuration();
  if ($_SESSION == []) {
    header('Location:'.$config->getConstantByKey('loginPage'));
    exit();
  }
 }

}
?>