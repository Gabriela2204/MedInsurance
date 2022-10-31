<?php
namespace App\Entity;
class Customer{
        

    public $name;
    public $adress;

    public function __construct( $name = NULL , $adress = NULL){

      $this->name = $name;
      $this->adress = $adress;
    }



   public function getName(){

    return $this->name;

   }
   public function getAdress(){

    return $this->adress;

   }


   public function setName($name){
   
    $this->name = $name;

   }
   public function setAdress($adress){
   
    $this->adress = $adress;

   }
  
}

?>