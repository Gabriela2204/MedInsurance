<?php
namespace App\Entity;

use App\Attribute\Required;

class Type
{
    public int $id;
    #[Required]
    public string $name;
    public bool $multiple;

    public function getId() :int 
    {
        return $this->id;
    } 

}

?>