<?php

namespace App\Repository;

class Services extends BaseRepository{

    public function searchId(string $name): array{

        return $this->queryAndFetch("SELECT id from services where name ="."'".$name."'");
    }

    public function searchPrice(string $name): array{

        return $this->queryAndFetch("SELECT price from services where name ="."'".$name."'");
    }

    public function getServicesDetails(int $id_insurances): array{
        return $this->queryAndFetch("select services.name, service_insurances.price from services 
        inner join service_insurances on services.id = service_insurances.id_service
        where service_insurances.id_insurances =".$id_insurances);
    }

}

?>