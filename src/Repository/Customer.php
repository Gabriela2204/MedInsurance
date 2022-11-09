<?php
   namespace App\Repository;

   class Customer extends BaseRepository{
    
    public function searchId($name){
      return $this->queryAndFetch("select id from customer where name = "."'".$name."'");
    }
    
  }
?>