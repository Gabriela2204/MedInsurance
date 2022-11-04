<?php
namespace App\Entity;

use App\Attribute\OnlyLetters;
use App\Attribute\Required;


// use Attribute;

// #[Attribute(Attribute::TARGET_PROPERTY)]
 
class Customer{
        
    #[Required, OnlyLetters]
    public string $name;
    
    #[Required]
    public string $adress;

    public function __construct(string $name = NULL ,string $adress = NULL){

      $this->name = $name;
      $this->adress = $adress;
    }



   public function getName():string {

    return $this->name;

   }
   public function getAdress():string{

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