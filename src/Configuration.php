<?php

namespace App;


class Configuration{

    private $localhost;
    private $user;
    private $dbname;
    private $pass;


    public function __construct()
    {
        $const = json_decode(file_get_contents('src\Constants.json'), true);
        $this->localhost = $const['localhost'];
        $this->user = $const['user'];
        $this->dbname = $const['dbname'];
        $this->pass = $const['pass'];
    }

    public function getLocalhost(){
  
        return $this->localhost; 

    }
    public function getUser(){
  
        return $this->user; 

    }
    public function getDbname(){
  
        return $this->dbname; 

    }
    public function getPass(){
  
        return $this->pass; 

    }
}

?>