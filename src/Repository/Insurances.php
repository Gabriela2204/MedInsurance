<?php
   namespace App\Repository;
   

   class Insurances extends BaseRepository{
    
      public $sql= "select insurances.id, insurances_customer.pricing ,insurances_customer.id_insurances as ID,
      insurances_customer.start_time, insurances_customer.status, type.name as Type, customer.name as Client from insurances
      inner join insurances_customer on insurances.id = insurances_customer.id_insurances
      inner join type on insurances.id_type = type.id
      inner join customer on customer.id =  insurances_customer.id_customer ";

    
    public function AllInfo(): ?array{
          
          return $this->queryAndFetch( $this->sql);
    }

   
 
   }
 


?>