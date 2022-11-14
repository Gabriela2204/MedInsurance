<?php
   namespace App\Repository;
  

   class Insurances_customer extends BaseRepository{
    
      public function getIdInsurances(int $id_customer): array
      {
         return $this->queryAndFetch("select id_insurances from insurances_customer where id_customer like '".$id_customer."'");
      }
   }
   
   ?>