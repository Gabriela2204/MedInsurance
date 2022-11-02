<?php
namespace App;

class Request{
  
    private string $RequestMethod;

    
    public function __construct()
    {
        $this->RequestMethod = $_SERVER['REQUEST_METHOD'];
        
    }

    public function getValue($key){
        return $_REQUEST[$key];
    }
 

}

?>