<?php
   namespace App\Repository;
   use App\Entity\Insurances as Insurances;

   class Insurance extends AbstractRepository{
    
     use BaseRepository;

    public function AllInfo(){
          
          return $this->queryAndFetch('select insurances.id , insurances_customer.pricing ,
          insurances_customer.start_time, insurances_customer.status, type.name as Type, customer.name as Client from insurances
          inner join insurances_customer on insurances.id = insurances_customer.id_insurances
          inner join type on insurances.id_type = type.id
          inner join customer on customer.id =  insurances_customer.id_customer ');
    }
    
     public function insert(Insurances $insurance){
        
       
        return $this->queryAndFetch('insert into insurances(id, id_type) values ('.$insurance->getId().','.$insurance->getId_Type().')');

    }


    public function update(Insurances $insurance , $id){
         
        return $this->queryAndFetch('update insurances set id_type = '.$insurance->getId().'where id='.$id);

    }
 
   }
 
?>