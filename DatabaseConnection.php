<?php

require('Constants.php');

class DatabaseConnection{
   
   private static $instance;
   protected $dbh = null;

  public function __construct(){
   
   // $this->instance = $instance;
   // $this->dbh = $dbh;

  }

   public static function getInstance()
   {
      if(!isset(self::$instance)) {
        self::$instance = new static();
     try{   
 
      $dbh = new \PDO('mysql:host='.localhost.';dbname='.dbname, user, pass);
        }catch(\Exception $e){
           echo $e->getMessage();
        }
    
     }else{
        echo "already connected";
     }
  
      return $dbh;

   }

   // private function query()
   // {
   //  if($this->dbh == null)
   //  return "eroare";
   //  else
   //   return $this->dbh->query();
   // }

}

// $obj = DatabaseConnection::getInstance();
// $obj1 = DatabaseConnection::getInstance();
// $sql = 'select * from insurers';
// $result = $obj1->query($sql);
// $response= $result->fetchAll();
// print_r($response);


?>