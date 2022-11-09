<?php
namespace App\Entity;
class Insurers_insurances{

    public int $id_insurers ;
    public string $id_insurances;

    public function __construct(int $id_insurers,int $id_insurances)
    {
        $this->id_insurers = $id_insurers;
        $this->id_insurances = $id_insurances;
    }

}

?>