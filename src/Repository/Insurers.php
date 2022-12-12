<?php
   namespace App\Repository;
  

class Insurers extends BaseRepository
{
    public function getServicesByInsurerName(string $name): array
    {
        $id = $this->queryAndFetchForOne("SELECT id FROM insurers WHERE name = ? ",[$name]);
        $services = $this->queryAndFetch(" SELECT  services.name FROM services
        INNER JOIN insurers_services ON services.id = insurers_services.id_services
        WHERE insurers_services.id_insurers = ?",[$id->id]);
        return $services;
    }

    public function getNameByInsurerId(int $idInsurer): array
    {
        return $this->queryAndFetch("SELECT name FROM  insurers WHERE id = ?",[$idInsurer]);
    }

    public function getIdInsurerByInsurer(string $name): ?array
    {
        return $this->queryAndFetch("SELECT id FROM insurers WHERE name = ?",[$name]);
    }

}
   
?>