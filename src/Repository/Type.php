<?php

namespace App\Repository;

class Type extends BaseRepository{

    public function searchId(string $name): array{

        return $this->queryAndFetch("SELECT id from type where name ="."'".$name."'");
    }
    
   public function getNames(): array{

    return $this->queryAndFetch("SELECT name FROM  type where name != 'Basic' ");

   }

   public function getType(int $id_insurances){
    return $this->queryAndFetch("Select type.name from type 
    inner join insurances on type.id = insurances.id_type 
    where insurances.id like '".$id_insurances."'");
   }

   public function getMultiple(string $type){
     return $this->queryAndFetch("select multiple, id from type where name = '".$type."'");
   }
}

?>