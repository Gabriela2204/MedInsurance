<?php
namespace App\Entity;
class Service_insurances{

    public ?int $id_service = null;
    public string $id_insurances;

    public function __construct(int $id_service,int $id_insurances)
    {
        $this->id_service = $id_service;
        $this->id_insurances = $id_insurances;
    }

}

?>