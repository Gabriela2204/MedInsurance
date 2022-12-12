<?php
namespace App\Repository;
   
class Insurances extends BaseRepository
{ 
  public $sql = "SELECT insurances.id,insurances_customer.id_insurances AS ID,
    insurances_customer.start_time,  insurances_customer.end_time , insurances_customer.status, type.name AS Type, customer.name AS Client FROM insurances
    INNER JOIN insurances_customer ON insurances.id = insurances_customer.id_insurances
    INNER JOIN type ON insurances.id_type = type.id
    INNER JOIN customer ON customer.id =  insurances_customer.id_customer ";

  public function allInfo(): ?array
  {
    return $this->queryAndFetch( $this->sql);
  }

  public function allInfoForInsurer(int $id_insurer)
  {
    return $this->queryAndFetch('SELECT insurances.id,insurers.name AS Name,
    insurances_customer.start_time,  insurances_customer.end_time , insurances_customer.status, type.name AS Type, customer.name AS Client FROM insurances
    INNER JOIN insurances_customer ON insurances.id = insurances_customer.id_insurances
    INNER JOIN type ON insurances.id_type = type.id
    INNER JOIN customer ON customer.id =  insurances_customer.id_customer
    INNER JOIN insurers_insurances ON insurers_insurances.id_insurances = insurances.id
    INNER JOIN insurers ON insurers.id = insurers_insurances.id_insurers
    WHERE insurers_insurances.id_insurers = ?', [$id_insurer]);
  }

  public function LastInsurance(): ?array
  {
    return $this->queryAndFetch("SELECT * FROM insurances WHERE id = (SELECT MAX(id) FROM insurances)");
  }

  public function getInsurancesDetails($id_customer, $id_insurances)
  {
    return $this->queryAndFetchForOne($this->sql."WHERE customer.id = ? AND insurances.id = ? ",[$id_customer,$id_insurances]);
  }

  public function verifyInsuranceExisting($id_type, $customer)
  {
    return $this->queryAndFetchForOne("SELECT count(insurances.id) AS Number from insurances_customer INNER JOIN insurances
      ON insurances_customer.id_insurances = insurances.id INNER JOIN customer
      ON insurances_customer.id_customer = customer.id 
      WHERE customer.name = ? AND insurances.id_type = ?",[$customer,$id_type]);
  }
}
 
?>