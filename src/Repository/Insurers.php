<?php
   namespace App\Repository;
  

   class Insurers extends BaseRepository{
    
 
    public function getServices(int $id): array{
        return $this->queryAndFetch(" SELECT  services.description , services.price from services
        inner join insurers_services on services.id = insurers_services.id_services
        where insurers_services.id_insurers = ".$id);
    }

   }
   
   ?>