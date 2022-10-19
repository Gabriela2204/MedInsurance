<?php
 

class DatabaseConnection{
   
   private static $instance;
   private static $dbh ;
  
   private function __construct(){
      
      $const = json_decode(file_get_contents('Constants.json'), true);
      self::$dbh = new \PDO('mysql:host='.$const['localhost'].';dbname='.$const['dbname'],
      $const['user'], $const['pass']);
      
       
   }

   public function __clone(){
      throw new Exception("Can't clone");
   }

   public function __wakeup()
   {
      throw new Exception("Can't unserialize ");
   }

   public function __serialize()
   {
      throw new Exception("Can't serialize ");
   }

   public static function getInstance(){
      if(!isset(self::$instance)) {
        self::$instance = new static(); 

      }
      return self::$dbh;
   
   }

}

?>
