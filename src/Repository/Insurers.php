<?php
   namespace App\Repository;
  

class Insurers extends BaseRepository
{
    public function getServices(string $name): array
    {
        $id = $this->queryAndFetch("SELECT id from insurers where name = "."'".$name."'");
        $services = $this->queryAndFetch(" SELECT  services.name from services
        inner join insurers_services on services.id = insurers_services.id_services
        where insurers_services.id_insurers = ".$id[0]->id);
        return $services;
    }

    public function getNames(): array
    {
        return $this->queryAndFetch("SELECT name FROM  insurers");
    }

    public function getIdInsurer(string $name): ?array
    {
        return $this->queryAndFetch("SELECT id from insurers where name = "."'".$name."'");
    }

}
   
?>