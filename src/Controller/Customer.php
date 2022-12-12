<?php

namespace App\Controller;

use App\Views\View as View;
use App\Repository\Customer as CustomerRepo;
use App\Entity\Insurances as InsurancesEntity;
use App\DatabaseConnection as Database;
use App\Entity\Insurances_customer as Insurances_customerEntity;
use App\Entity\Customer as CustomerEntity;
use App\Entity\Insurers_insurances as Insurers_insurancesEntity;
use App\Repository\Insurances as InsurancesRepo;
use App\Repository\Insurances_customer as Insurances_customerRepo;
use App\Repository\Insurers_insurances as Insurers_insurancesRepo ;
use App\Repository\Services as ServiceRepo;
use App\Repository\Type as TypeRepo;
use App\Validater;

class Customer extends BaseController
{

    private function addBasicInsurance(int $idCustomer)
    {
      $insuranceEntity = new InsurancesEntity(1);
      $insuranceRepo = new InsurancesRepo();
      $insuranceRepo->insert($insuranceEntity); 
      $idInsurer = $this->session->getValue('user')->id_insurer;
      $dbh = Database::getInstance();
      $insuranceID = $dbh->lastInsertID();
      $this->addInsurersInsurance($idInsurer, $insuranceID);
      $this->addInsuranceCustomer($idCustomer, $insuranceID);
    }

    public function addInsurersInsurance(int $idInsurer, int $idInsurances)
    {
      $insurerInsuranceRepo = new Insurers_insurancesRepo;
      $insurerInsurancesEntity = new Insurers_insurancesEntity($idInsurer, $idInsurances);
      $insurerInsuranceRepo->insert($insurerInsurancesEntity);
    }

    private function addInsuranceCustomer(int $idCustomer, int $idInsurances)
    {
      $time = time();
      $end = date('Y-m-d', strtotime('+10 years'));
      $insurance_customerEntity = new Insurances_customerEntity($idInsurances,$idCustomer,date("Y-m-d h-m-s",$time),$end,"valabil");
      $insurance_customerRepo = new Insurances_customerRepo();
      $insurance_customerRepo->insert($insurance_customerEntity);
    }

    private function add()
    {
      if ($this->request->getRequestMethod() == 'POST' && $this->request->getValue('add')) {
        $customer = new CustomerEntity($this->request->getValue('name_form'), $this->request->getValue('adress_form'));
        $valid = new Validater();
        if ($valid->validate($customer) == null) {
          $customerRepo = new CustomerRepo();
          $customerRepo->insert($customer);
          $dbh = Database::getInstance(); 
          $this->addBasicInsurance($dbh->lastInsertId());
        }
        $error = $valid->validate($customer);
        return $error;
      }
    }  

    public function addNewCustomer()
    { 
      $this->verifySession();
      $view = new View();
      $view->AddNewCustomer($this->add());
           
    }

    public function overview()
    {
      $this->verifySession();
      $idInsurer = $this->session->getValue('user')->id_insurer;
      $customerRepo = new CustomerRepo();
      $view = new View();
      if ($this->filter() != []) {
        $data = $this->filter();
      } else {
          $data = $customerRepo->getAllInfoForInsurer($idInsurer);
        }
        $view ->CustomerOverview($data);
    }

    private function filter(): ?array
    {   
      if ($this->request->getRequestMethod() === 'POST') {
        if ($this->request->verifyIfIsset('search')!=null || $this->request->verifyIfIsset('reset')!=null) {
          if ($this->request->getValue('search_box') !=null) {
            $customerRepo = new CustomerRepo();   
            $search= $this->request->getValue('search_box');
            $query = $customerRepo->filter($search);
            return $query;
          }
           
        }
      }
      return [];
  }
  private function serviceInsurance($idInsurance)
  { 
    $servicesRepo = new ServiceRepo();
    $services = $servicesRepo->getServicesDetailsByIdInsurances($idInsurance->id_insurances);
    $data = array();
    foreach ($services as $service) {
      array_push($data ,$service->name);
    }
    return $data;
  }

  private function price($idInsurance,$type)
  {
    $servicesRepo = new ServiceRepo();
    $services = $servicesRepo->getServicesDetailsByIdInsurances($idInsurance->id_insurances);
    $price = 0;
    foreach ($services as $service) {
      $price += $service->price;
    }
    if ($type == 'Dental') {
      $price = 12*$price;
    }
    if ($type == 'Basic') {
      $price = 'Free';
    }
    return $price;
  }

  private function detailsInsurances($idCustomer)
  {
    $insurancesCustomerRepo =  new Insurances_customerRepo();
    $typeRepo = new TypeRepo();
    $repoInsurances = new InsurancesRepo();
    $idsInsurances = $insurancesCustomerRepo->getInsurancesIdByCustomer($idCustomer);
    
    $data = array();
    foreach ($idsInsurances as $idInsurance) {
      $insuranceDetails = $repoInsurances->getInsurancesDetails($idCustomer,$idInsurance->id_insurances );
      $type = $typeRepo->getType($idInsurance->id_insurances); 
      $data[$idInsurance->id_insurances]['Id'] =  $insuranceDetails->ID;
      $data[$idInsurance->id_insurances]['Start_time'] =  $insuranceDetails->start_time;
      $data[$idInsurance->id_insurances]['End_date'] =  $insuranceDetails->end_time;
      $data[$idInsurance->id_insurances]['Status'] =  $insuranceDetails->status;
      $data[$idInsurance->id_insurances]['Type'] = $type->name;
      $data[$idInsurance->id_insurances]['Services'] = $this->serviceInsurance($idInsurance);
      $data[$idInsurance->id_insurances]['Price'] = $this->price($idInsurance,$type->name);
    }
    return $data;
  }
  
  public function ViewDetails()
  {
    if ($this->request->getRequestMethod() == 'GET' && $this->request->verifyIfIsset('id')) {
      $idCustomer = $this->request->getValue('id');
      $insurancesCustomerRepo =  new Insurances_customerRepo(); 
      $idsInsurances = $insurancesCustomerRepo->getInsurancesIdByCustomer($idCustomer);
      $error = "";
      $ok = 0;
      $data = [];
      foreach ($idsInsurances as $idInsurance) {
        $idInsurer = $insurancesCustomerRepo->getIdInsurer($idInsurance->id_insurances);
        if ($idInsurer) {
          if($idInsurer->id_insurers == $this->session->getValue('user')->id_insurer){
            $ok=1;
            break;
          }
        }  
      }
      if ($ok == 1) {
        $data = $this->detailsInsurances($idCustomer);
      } else {
        $error = "This customer does't exists";
      }
    }
    $view = new View();
    $view->ViewDetails($data,$error);
  }

}



?>