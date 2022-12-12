<?php
   namespace App\Repository;
  

class Insurances_customer extends BaseRepository
{
   public function getInsurancesIdByCustomer(int $id_customer): array
   {
      return $this->queryAndFetch("select id_insurances from insurances_customer where id_customer like ? ",[$id_customer]);
   }
   public function getIdInsurer(int $id_insurances)
   {
      return $this->queryAndFetchForOne("select id_insurers from insurers_insurances where id_insurances = ?" ,[$id_insurances]);
   }
}
   
   ?>