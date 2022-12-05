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

  public function allInfoForInsurer(int $idInsurer)
  {
    return $this->queryAndFetch("SELECT distinct customer.id, customer.name , customer.adress from customer
    inner join insurances_customer on customer.id = insurances_customer.id_customer
    inner join insurances on insurances_customer.id_customer = insurances.id
    inner join insurers_insurances on insurances.id = insurers_insurances.id_insurances
    where insurers_insurances.id_insurers = ".$idInsurer);
  }

  public function filter(int|string $search)
  {
    return $this->queryAndFetch("select id, name, adress from customer where name LIKE  '%{$search}%' or adress LIKE  '%{$search}%'");
  }
    
}

?>