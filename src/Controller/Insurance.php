<?php

namespace App\Controller;

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
        $view ->Overview($repo->AllInfo(),$this->filter());
       
    
        
    }

    public function addNewInsurance()
    {
        
        $insurer = new InsurersRepo;
        $services = [];
        if($this->request->getRequestMethod() === 'GET' && $this->request->verifyIfIsset('Services')){
            if($this->request->verifyIfIsset('name_insurer')){
            $services = $insurer->getServices($this->request->getValue('name_insurer'));
            }
        }

        $this->add();
        $view = new View();
        $view ->AddNewInsurance($insurer->getNames(), $services);
    }

    public function newInsurance(string $type){
        $repoType = new TypeRepo;
        $idType = $repoType->searchId($type);
        $newInsurance = new Insurances($idType[0]->id);
        $repoInsurance = new InsuranceRepo;
        $repoInsurance->insert($newInsurance);


    }
    public function newServiceInsurances(int $idServices){

        $idInsurances = $this->insuranceId();
        $newServiceInsurance = new EntityService_insurances($idServices,$idInsurances[0]->id);
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
    }

    public function newInsuranceCustomer(string $customer ,string $insuranceType, array $services){

        $idInsurances = $this->insuranceId();
        $repoCustomer = new CustomerRepo;
        $idCustomer = $repoCustomer->searchId($customer);
        $repoInsuranceCustomer = new Insurances_customer;
        $repoServices = new  ServicesRepo;
        $time= time();
        $start_time =date("Y-m-d H:i:s",$time);
        if($insuranceType == 'Private')
            $end_time = date("Y-m-d H:i:s", strtotime($start_time.'+ 1 months'));
        else 
            $end_time = date("Y-m-d H:i:s", strtotime($start_time.'+ 3 months')); 
        $status = 'valabil';
        $pricing =0;
        foreach($services as $service){
           $pricing = $pricing + $repoServices->searchPrice($service)[0]->price;
        }
        $newInsuranceCustomer = new EntityInsurances_customer($idInsurances[0]->id, $idCustomer[0]->id,$pricing,$start_time,$end_time,$status);
        $repoInsuranceCustomer ->insert($newInsuranceCustomer);
    }

    public function add(){

        if($this->request->getRequestMethod() == 'POST' && $this->request->verifyIfIsset('add')){
           $type = $this->request->getValue('type_form');
           $customer=  $this->request->getValue('customer_form');
           $checkbox = $this->request->getValue('checkbox');
           $insurerName = $this->request->getValue('name_insurer');
           $repoServices = new ServicesRepo;
           $this->newInsurance($type);

           foreach ($checkbox as $service) {
         
            $idServices = $repoServices->searchId($service);
            $this->newServiceInsurances($idServices[0]->id);

        }
           $this->newInsurerInsurances($insurerName);
           $this->newInsuranceCustomer($customer,$type,$checkbox);

        
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

      public function InsurerServices(): array{
     
              if($this->request->getValue('Services')!=null  && $this->request->getValue('insurer_form')!=null ){
                 
                 $insurer= $this->request->getValue('insurer_form');
                 $repo = new InsuranceRepo;
                return $repo->queryAndFetch("Select id from insurers where name = '{$insurer}'");     
      }
      
      return [];

    }
}



?>