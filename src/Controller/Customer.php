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
use App\Validater;

class Customer extends BaseController{

    public function addBasicInsurance(int $id_customer){
        $insurance = new Insurances(1);
        $insuranceRepo = new RepositoryInsurances;
        $insuranceRepo->insert($insurance); 
        $dbh = Database::getInstance();
        $this->addInsuranceCustomer($id_customer,$dbh->lastInsertID());
      }

      public function addInsuranceCustomer(int $id_customer, int $id_insurances){
  
        $time = time();
        $end = date('Y-m-d', strtotime('+10 years'));
        $insurance_customer = new Insurances_customer($id_insurances,$id_customer,0,date("Y-m-d h-m-s",$time),$end,"valabil");
        $insurance_customerRepo = new RepositoryInsurances_customer;
        $insurance_customerRepo->insert($insurance_customer);
  
  
      }
      public function add() {
        
        if($this->request->getRequestMethod() == 'POST' && $this->request->getValue('add')){
            $customer = new CustomerEntity($this->request->getValue('name_form'), $this->request->getValue('adress_form'));
            $valid = new Validater;
            if($valid->validate($customer) == null)
                {
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

}



?>