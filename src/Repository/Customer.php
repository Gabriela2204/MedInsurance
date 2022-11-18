<?php
namespace App\Repository;

class Customer extends BaseRepository
{
  public function searchId($name)
  {
    return $this->queryAndFetch("select id from customer where name = "."'".$name."'");
  }

  public function allInfo()
  {
    return $this->queryAndFetch("select id, name, adress from customer");
  }

  public function filter(int|string $search)
  {
    return $this->queryAndFetch("select id, name, adress from customer where name LIKE  '%{$search}%' or adress LIKE  '%{$search}%'");
  }
    
}

?>