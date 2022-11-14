<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Insurances;
use App\Entity\Insurances_customer as EntityInsurances_customer;
use App\Entity\Insurers_insurances;
use App\Entity\Service_insurances as EntityService_insurances;
use App\Repository\Customer as CustomerRepo;
use App\Views\View as View;
use App\Repository\Insurances as InsuranceRepo;
use App\Repository\Insurances_customer;
use App\Repository\Insurers as InsurersRepo;
use App\Repository\Insurers_insurances as RepositoryInsurers_insurances;
use App\Repository\Service_insurances;
use App\Repository\Services as ServicesRepo;
use App\Repository\Type as TypeRepo;
use App\Validater;


class Insurance extends BaseController{

    public function overview()
    {
        $repo = new InsuranceRepo;
        $view = new View();
        $view ->Overview($repo->allInfo(),$this->filter());
    }

    public function addNewInsurance()
    {
        
        $insurer = new InsurersRepo;
        $type = new TypeRepo;    
        $view = new View();
        $view ->AddNewInsurance($insurer->getNames(),$type->getNames(),$this->add());
    }

    public function insurerServices(){
        $insurer = new InsurersRepo;
        if($this->request->getRequestMethod() === 'GET' && $this->request->verifyIfIsset('name_insurer'))
            {  
           
               $services = $insurer->getServices($this->request->getValue('name_insurer'));
               $jsonServices = json_encode($services);
               print_r($jsonServices);
            }else
             echo 'Error';
       

    }
    
    public function newInsurance(string $type){
        $repoType = new TypeRepo;
        $idType = $repoType->searchId($type);
        $newInsurance = new Insurances($idType[0]->id);
        $repoInsurance = new InsuranceRepo;
        $repoInsurance->insert($newInsurance);


    }
    public function newServiceInsurances(int $idServices, $price){

        $idInsurances = $this->insuranceId();
        $newServiceInsurance = new EntityService_insurances($idServices,$idInsurances[0]->id, $price);
        $repoServiceInsurances = new Service_insurances;
        $repoServiceInsurances->insert($newServiceInsurance);
    } 

    public function newInsurerInsurances(string $insurerName){

        $repoInsurer = new InsurersRepo;
        $idInsurances = $this->insuranceId();
        $idInsurer= $repoInsurer->getIdInsurer($insurerName);
        $newInsurerInsurances = new Insurers_insurances($idInsurer[0]->id, $idInsurances[0]->id);
        $repoInsurerInsurances = new RepositoryInsurers_insurances;
        $repoInsurerInsurances->insert($newInsurerInsurances);

    }

    public function insuranceId(){
        $repoInsurance = new InsuranceRepo();
        $idInsurances = $repoInsurance->LastInsurance();
        return $idInsurances;
    }

    public function validateObject(object $object){
        $validater = new Validater;
        if( $validater->validate($object) != null)
        {
            $error = $validater->validate($object); 
            return $error;
        }
        return null;
    }
    public function verifyValues(string $type, string $insurer): array{
        $error = array();
         if($type == 'Select type')
                array_push($error ,'Select Type');
         if ($insurer == 'Select insurer') 
                array_push($error ,'Select Insurer'); 
         
       return $error;

    }
    public function verifyCustomer(string $name){

        $repo= new CustomerRepo;
        if($repo->searchId($name) == [])
          return $name.' must be a customer';
        return null;  
    }

    public function newInsuranceCustomer(string $customer ,string $insuranceType){

        $idInsurances = $this->insuranceId();
        $repoCustomer = new CustomerRepo;
        $idCustomer = $repoCustomer->searchId($customer);
        $repoInsuranceCustomer = new Insurances_customer;
      
        $time= time();
        $start_time =date("Y-m-d H:i:s",$time);
        if($insuranceType == 'Private')
            $end_time = date("Y-m-d H:i:s", strtotime($start_time.'+ 1 months'));
        else 
            $end_time = date("Y-m-d H:i:s", strtotime($start_time.'+ 3 months')); 
        $status = 'valabil';
        $newInsuranceCustomer = new EntityInsurances_customer($idInsurances[0]->id, $idCustomer[0]->id,$start_time,$end_time,$status);
        $repoInsuranceCustomer ->insert($newInsuranceCustomer);
    }

    public function verifyType($type, $customer){
        $repoType = new TypeRepo;
        $repoInsurance = new InsuranceRepo;
        $multipleId = $repoType->getMultiple($type);
        if($multipleId[0]->multiple != 1){
            $existing = $repoInsurance->verifyInsuranceExisting($multipleId[0]->id, $customer);
            if($existing[0]->Number >= 1)
            return "A ".$type." insurance is already registered";

        }

    }

    public function add(){

        if($this->request->getRequestMethod() == 'POST' && $this->request->verifyIfIsset('add')){
           $type = $this->request->getValue('type_form');
           $customer=  $this->request->getValue('customer_form');
        if($this->verifyType($type, $customer) !=null){
            $error= array($this->verifyType($type, $customer));
               return $error;
        }
           $insurerName = $this->request->getValue('name_insurer');
          if($this->request->verifyIfIsset('checkbox'))
                   $checkbox=$this->request->getValue('checkbox');
           if($this->verifyCustomer($customer) !=null ){
               $error= array($this->verifyCustomer($customer));
               return $error;
           }

           $repoServices = new ServicesRepo;
           $customerEntity = new Customer($customer);
           if($this->validateObject($customerEntity) == null && $this->verifyValues($type,$insurerName) ==[]){

           $this->newInsurance($type);
           foreach ($checkbox as $service) {
            $price = $repoServices->searchPrice($service)[0]->price;
            $idServices = $repoServices->searchId($service);
            $this->newServiceInsurances($idServices[0]->id , $price);

        }
           $this->newInsurerInsurances($insurerName);
           $this->newInsuranceCustomer($customer,$type,$checkbox);

        
        }
        else {
            $error = $this->verifyValues($type,$insurerName);
            if($this->validateObject($customerEntity)!=[]){
            foreach ($this->validateObject($customerEntity) as $err) {
                array_push($error,$err);
            }
        }
            return $error;
        }
    }

    }


    public function filter(): ?array{
          
        if($this->request->getRequestMethod() === 'POST'){
              if( $this->request->verifyIfIsset('search')!=null || $this->request->verifyIfIsset('reset')!=null ){

                 if( $this->request->getValue('search_box') !=null ){
                 $repo = new InsuranceRepo;   
                 $sqlFilter = $repo->sql;
                 $search= $this->request->getValue('search_box');
                 $sqlFilter  .=" where insurances_customer.status LIKE  '%{$search}%'";
                 if(strtotime($search)){
                    echo strtotime($search);
                    $sqlFilter  .=" or insurances_customer.start_time LIKE '{$search}'";
                 }  
                 $sqlFilter  .=" or type.name LIKE  '%{$search}%'";
                 $sqlFilter .=" or customer.name LIKE  '%{$search}%'"; 
                 $query = $repo->queryAndFetch( $sqlFilter );

                 return $query;
             }
             
      }
    }
       return [];
    }


}
 

?>