<?php
   namespace App\Repository;
   use App\Entity\Customer as CustomerEntity;
   use App\Entity\Insurances as Insurances;
   use App\DatabaseConnection as Database;
use App\Entity\Insurances_customer;
use App\Repository\Insurances as RepositoryInsurances;
use App\Repository\Insurances_customer as RepositoryInsurances_customer;

   class Customer extends BaseRepository{
    
    public function addBasicInsurance($id_customer){
      $insurance = new Insurances(1);
      $insuranceRepo = new RepositoryInsurances;
      $insuranceRepo->insert($insurance); 
      $dbh = Database::getInstance();
      $this->addInsuranceCustomer($id_customer,$dbh->lastInsertID());

    }

    public function addInsuranceCustomer($id_customer, $id_insurances){
  
      $time = time();
      $end = date('Y-m-d', strtotime('+10 years'));
      $insurance_customer = new Insurances_customer($id_insurances,$id_customer,0,date("Y-m-d h-m-s",$time),$end,"valabil");
      $insurance_customerRepo = new RepositoryInsurances_customer;
      $insurance_customerRepo->insert($insurance_customer);


    }
  
    public function validateName($var){

      if (ctype_alpha(str_replace(' ', '', $var)) === false) 
      return 0;
      return 1;
    }

    public function validateAdress($var){

      if (preg_match('~^[\p{L}\p{N}\s]+$~uD', $var) == 0) 
          return 0;
      return 1;
    }

    public function add(){
      session_start();
         
        
            if(isset($_POST['add'])){
               
               if($this->validateName( $_POST['name_form']) && $this->validateAdress($_POST['adress_form']) )
                 { $_SESSION['name_form'] =  $_POST['name_form'];
                    $_SESSION['adress_form'] = $_POST['adress_form'];
                 } else
                 return 0;
                 
               header('Location: index.php?controller=Customer&action=addNewCustomer');
               exit;
      
            }
            if(isset($_SESSION['name_form']) && isset($_SESSION['adress_form']))
           {
            $customer = new CustomerEntity($_SESSION['name_form'],$_SESSION['adress_form']);
            unset($_SESSION['name_form']);
            unset($_SESSION['adress_form']);
           $this->insert($customer);
           $dbh = Database::getInstance();
           $this->addBasicInsurance($dbh->lastInsertId());
           }




    

    }
    
 
   }
 


?>