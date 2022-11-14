<?php
namespace App\Entity;

use App\Attribute\Required;

class Services{

    public int $id;
    #[Required]
    public string $name;
    public string $description;
    public ?int $price;



}

?>