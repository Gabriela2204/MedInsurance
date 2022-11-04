<?php

namespace App\Controller;

use App\Request as Request;


class BaseController{

 public Request $request;

 public function __construct()
 {
    $this->request = new Request;
 }



}
?>