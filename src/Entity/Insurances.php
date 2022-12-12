<?php

namespace App\Entity;

class Insurances
{      
    public ?int $id_type;

    public function __construct(int $id_type = NULL )
    {
      $this->id_type = $id_type;
    }

    public function getId(): int
    {
      return $this->id;
     }
    
   public function getId_type(): int
   {
    return $this->id_type;
   }

   public function setId_type(int $id_type)
   {
    $this->id_type = $id_type;
   }
}

?>