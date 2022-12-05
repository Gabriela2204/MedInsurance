<?php
namespace App\Repository;
   
class Insurances extends BaseRepository
{ 
  public $sql= "select insurances.id,insurances_customer.id_insurances as ID,
    insurances_customer.start_time,  insurances_customer.end_time , insurances_customer.status, type.name as Type, customer.name as Client from insurances
    inner join insurances_customer on insurances.id = insurances_customer.id_insurances
    inner join type on insurances.id_type = type.id
    inner join customer on customer.id =  insurances_customer.id_customer ";

  public function allInfo(): ?array
  {
    return $this->queryAndFetch( $this->sql);
  }

  public function getAdmin(string $email)
  {
    return $this->queryAndFetch("SELECT is_admin FROM user where mail = '".$email."'");
  }
  public function getIdInsurer(string $email)
  {
    return $this->queryAndFetch("SELECT id_insurer FROM user where mail = '".$email."'");
  }

  public function allInfoForInsurer(int $id_insurer)
  {
    return $this->queryAndFetch('select insurances.id,insurers.name as Name,
    insurances_customer.start_time,  insurances_customer.end_time , insurances_customer.status, type.name as Type, customer.name as Client from insurances
    inner join insurances_customer on insurances.id = insurances_customer.id_insurances
    inner join type on insurances.id_type = type.id
    inner join customer on customer.id =  insurances_customer.id_customer
    inner join insurers_insurances on insurers_insurances.id_insurances = insurances.id
    inner join insurers on insurers.id = insurers_insurances.id_insurers
    where insurers_insurances.id_insurers = '. $id_insurer);
  }

  public function LastInsurance(): ?array
  {
    return $this->queryAndFetch("SELECT * FROM insurances WHERE id = (SELECT MAX(id) FROM insurances)");
  }

  public function getInsurancesDetails($id_customer, $id_insurances)
  {
    return $this->queryAndFetch($this->sql."where customer.id =".$id_customer." and insurances.id =".$id_insurances);
  }

  public function verifyInsuranceExisting($id_type, $customer)
  {
    return $this->queryAndFetch("select count(insurances.id) as Number from insurances_customer inner join insurances
      on insurances_customer.id_insurances = insurances.id inner join customer
      on insurances_customer.id_customer = customer.id 
      where customer.name = '".$customer."' and insurances.id_type = ".$id_type);
  }
}
 
?>