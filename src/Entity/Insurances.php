<?php

namespace App\Entity;

class Insurances{
        
    public  $id;
    public $id_type;

    public function __construct($id = NULL,$id_type = NULL ){
      $this->id = $id;
      $this->id_type = $id_type;
    }

   public function getId(){
    
    return $this->id;

   }

   public function getId_type(){

    return $this->id_type;

   }

   public function setID($id){

     $this->id = $id;

   }

   public function setId_type($id_type){
   
    $this->id_type = $id_type;

   }
  
}

?>