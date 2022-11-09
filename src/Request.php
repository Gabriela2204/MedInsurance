<?php
namespace App;

class Request{
  
    private string $RequestMethod;
    private string $QueryString;
    
    
    public function __construct()
    {
        $this->RequestMethod = $_SERVER['REQUEST_METHOD'];
        $this->QueryString = $_SERVER['QUERY_STRING'];
        
    }

    public function getValue(string $key){
        return $_REQUEST[$key];
    }

    public function verifyIfIsset(string $key){
        return isset($_REQUEST[$key]);
    }
 
    public function getRequestMethod(): string{
        return $this->RequestMethod;
    }

    public function getQueryString(): string{
        return $this->QueryString;
    }

}

?>