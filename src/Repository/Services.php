<?php

namespace App\Repository;

class Services extends BaseRepository
{
    public function getIdByName(string $name): array
    {
        return $this->queryAndFetch("SELECT id FROM services WHERE name = ?",[$name]);
    }

    public function getPriceByName(string $name): array
    {
        return $this->queryAndFetch("SELECT price FROM services WHERE name = ?",[$name]);
    }

    public function getServicesDetailsByIdInsurances(int $id_insurances): array
    {
        return $this->queryAndFetch("SELECT services.name, service_insurances.price FROM services 
        INNER JOIN service_insurances ON services.id = service_insurances.id_service
        WHERE service_insurances.id_insurances = ?",[$id_insurances]);
    }
}

?>