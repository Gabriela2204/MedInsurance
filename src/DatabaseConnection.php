<?php
 
namespace App;
use App\Configuration as Configuration;

class DatabaseConnection
{
   private static $instance;
   private static $dbh ;
  
   private function __construct() 
   {
      $config = new Configuration();
      self::$dbh = new \PDO('mysql:host='.$config->getConstantByKey("localhost").';dbname='.$config->getConstantByKey("dbname"),
      $config->getConstantByKey("user"), $config->getConstantByKey("pass")); 
   }

   public function __clone()
   {
      throw new \Exception("Can't clone");
   }

   public function __wakeup()
   {
      throw new \Exception("Can't unserialize ");
   }

   public function __serialize()
   {
      throw new \Exception("Can't serialize ");
   }

   public static function getInstance()
   {
      if (!isset(self::$instance)) {
        self::$instance = new static(); 
      }
      return self::$dbh;
   }
}

?>
