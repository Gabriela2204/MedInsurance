<?php
namespace App\Repository;

class Customer extends BaseRepository
{
  public function getId($name)
  {
    return $this->queryAndFetch("SELECT id FROM customer WHERE name = ?",[$name]);
  }

  public function getAllInfoForInsurer(int $idInsurer)
  {
    return $this->queryAndFetch("SELECT DISTINCT customer.id, customer.name , customer.adress FROM customer
    INNER JOIN insurances_customer ON customer.id = insurances_customer.id_customer
    INNER JOIN insurances ON insurances_customer.id_customer = insurances.id
    INNER JOIN insurers_insurances ON insurances.id = insurers_insurances.id_insurances
    WHERE insurers_insurances.id_insurers = ?",[$idInsurer]);
  }

  public function filter(int|string $search)
  {
    return $this->queryAndFetch("SELECT id, name, adress FROM customer WHERE name LIKE  ? OR adress LIKE  ?",[$search,$search]);
  }

  public function getCustomersByInsurer(int $idInsurer)
  {
    return $this->queryAndFetch("SELECT DISTINCT customer.name FROM customer INNER JOIN insurances_customer ON customer.id = insurances_customer.id_customer
    INNER JOIN insurers_insurances ON insurances_customer.id_insurances= insurers_insurances.id_insurances
    WHERE insurers_insurances.id_insurers = ?",[$idInsurer]);
  }
    
}

?>