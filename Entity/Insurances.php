<?php

namespace Entity;

class Insurances{
        
    public  $id;
    public $id_type;

   function __construct($id, $id_type){
        
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