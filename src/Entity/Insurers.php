<?php
namespace App\Entity;

class Insurers{
        

    public ?string $name;
    public ?string $adress;

    public function __construct(string $name = NULL ,string $adress = NULL){

      $this->name = $name;
      $this->adress = $adress;
    }



   public function getName(): string{

    return $this->name;

   }
   public function getAdress(): string{

    return $this->adress;

   }


   public function setName(string $name){
   
    $this->name = $name;

   }
   public function setAdress(string $adress){
   
    $this->adress = $adress;

   }
  
}

?>