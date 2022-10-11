<?php
 
require('Constants.php');

class DatabaseConnection{
   
   private static $instance;
   private static $dbh ;


   public static function getInstance()
   {
      if(!isset(self::$instance)) {
        self::$instance = new static();
     try{   
 
      $dbh = new \PDO('mysql:host='.localhost.';dbname='.dbname, user, pass);
      return $dbh;
        }catch(\Exception $e){
           echo $e->getMessage();
        }
      
   }
   else{
      return self::$dbh;
   }
}

  

}


?>