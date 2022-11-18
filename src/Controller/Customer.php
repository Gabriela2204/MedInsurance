<?php

namespace App\Controller;

use App\Views\View as View;
use App\Repository\Customer as CustomerRepo;
use App\Entity\Insurances as Insurances;
use App\DatabaseConnection as Database;
use App\Entity\Insurances_customer;
use App\Entity\Customer as CustomerEntity;
use App\Repository\Insurances as RepositoryInsurances;
use App\Repository\Insurances_customer as RepositoryInsurances_customer;
use App\Repository\Services;
use App\Repository\Type;
use App\Validater;

class Customer extends BaseController
{

    private function addBasicInsurance(int $id_customer)
    {
      $insurance = new Insurances(1);
      $insuranceRepo = new RepositoryInsurances;
      $insuranceRepo->insert($insurance); 
      $dbh = Database::getInstance();
      $this->addInsuranceCustomer($id_customer,$dbh->lastInsertID());
    }

    private function addInsuranceCustomer(int $id_customer, int $id_insurances)
    {
      $time = time();
      $end = date('Y-m-d', strtotime('+10 years'));
      $insurance_customer = new Insurances_customer($id_insurances,$id_customer,date("Y-m-d h-m-s",$time),$end,"valabil");
      $insurance_customerRepo = new RepositoryInsurances_customer;
      $insurance_customerRepo->insert($insurance_customer);
    }

    private function add()
    {
      if ($this->request->getRequestMethod() == 'POST' && $this->request->getValue('add')) {
        $customer = new CustomerEntity($this->request->getValue('name_form'), $this->request->getValue('adress_form'));
        $valid = new Validater;
        if ($valid->validate($customer) == null) {
          $repo = new CustomerRepo;
          $repo->insert($customer);
          $dbh = Database::getInstance(); 
          $this->addBasicInsurance($dbh->lastInsertId());
        }
        $error = $valid->validate($customer);
        return $error;
      }
    }  

    public function addNewCustomer()
    {
      $view = new View();
      $view->AddNewCustomer($this->add());
           
    }

    public function overview()
    {
      $repo = new CustomerRepo;
      $view = new View();
      if ($this->filter() != []) {
        $data = $this->filter();
      } else {
          $data = $repo->allInfo();
      }
        $view ->CustomerOverview($data);
    }

    private function filter(): ?array
    {   
      if ($this->request->getRequestMethod() === 'POST') {
        if ($this->request->verifyIfIsset('search')!=null || $this->request->verifyIfIsset('reset')!=null) {
          if ($this->request->getValue('search_box') !=null) {
            $repo = new CustomerRepo;   
            $search= $this->request->getValue('search_box');
            $query = $repo->filter($search);
            return $query;
          }
           
        }
      }
      return [];
  }
  private function serviceInsurance($idInsurance)
  { 
    $repoServices = new Services;
    $services = $repoServices->getServicesDetails($idInsurance->id_insurances);
    $data = array();
    foreach ($services as $service) {
      array_push($data ,$service->name);
    }
    return $data;
  }

  private function price($idInsurance,$type)
  {
    $repoServices = new Services;
    $services = $repoServices->getServicesDetails($idInsurance->id_insurances);
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
    $repoInsurancesCustomer =  new RepositoryInsurances_customer();
    $repoType = new Type;
    $repoInsurances = new RepositoryInsurances;
    $idsInsurances = $repoInsurancesCustomer->getIdInsurances($idCustomer);
    $data = array();
    foreach ($idsInsurances as $idInsurance) {
      $insuranceDetails = $repoInsurances->getInsurancesDetails($idCustomer,$idInsurance->id_insurances );
      $type = $repoType->getType($idInsurance->id_insurances); 
      $data[$idInsurance->id_insurances]['Id'] =  $insuranceDetails[0]->ID;
      $data[$idInsurance->id_insurances]['Start_time'] =  $insuranceDetails[0]->start_time;
      $data[$idInsurance->id_insurances]['End_date'] =  $insuranceDetails[0]->end_time;
      $data[$idInsurance->id_insurances]['Status'] =  $insuranceDetails[0]->status;
      $data[$idInsurance->id_insurances]['Type'] = $type[0]->name;
      $data[$idInsurance->id_insurances]['Services'] = $this->serviceInsurance($idInsurance);
      $data[$idInsurance->id_insurances]['Price'] = $this->price($idInsurance,$type[0]->name);
    }
    return $data;
  }
  
  public function ViewDetails()
  {
    if ($this->request->getRequestMethod() == 'GET' && $this->request->verifyIfIsset('id')) {
      $idCustomer = $this->request->getValue('id');
      $data = $this->detailsInsurances($idCustomer);
    }
    $view = new View;
    $view->ViewDetails($data);
  }

}



?>