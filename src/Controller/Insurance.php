<?php

namespace App\Controller;

use App\Entity\Insurances as InsurancesEntity;
use App\Entity\Customer as CustomerEntity;
use App\Entity\Insurances_customer as Insurances_customerEntity;
use App\Entity\Insurers_insurances as Insurers_insurancesEntity;
use App\Entity\Service_insurances as Service_insurancesEntity;
use App\Repository\Customer as CustomerRepo;
use App\Views\View as View;
use App\Repository\Insurances as InsuranceRepo;
use App\Repository\Insurances_customer as Insurances_customerRepo;
use App\Repository\Insurers as InsurersRepo;
use App\Repository\Insurers_insurances as Insurers_insurancesRepo;
use App\Repository\Service_insurances as Service_insurancesRepo;
use App\Repository\Services as ServicesRepo;
use App\Repository\Type as TypeRepo;
use App\Validater;
use App\Configuration;


class Insurance extends BaseController
{
    public function overview()
    {
        $this->verifySession();
        $idInsurer =  $this->session->getValue('user')->id_insurer;
        $insuranceRepo = new InsuranceRepo();
        $view = new View();
        $view ->Overview($insuranceRepo->allInfoForInsurer($idInsurer),$this->filter());
    }

    public function logout()
    {   
        $this->session->unsetVariable('user');
        $config = new Configuration();
        header('Location:'.$config->getConstantByKey('loginPage'));
        exit();
    }

    public function addNewInsurance()
    {   
        $this->verifySession();
        $idInsurer =  $this->session->getValue('user')->id_insurer;
        $customerRepo = new CustomerRepo;
        $insurerRepo = new InsurersRepo();
        $typeRepo = new TypeRepo();    
        $view = new View();
        $view ->AddNewInsurance($insurerRepo->getNameByInsurerId($idInsurer),$typeRepo->getNames(),$customerRepo->getCustomersByInsurer($idInsurer),$this->add());
    }

    public function insurerServices()
    {   
        // header('Content-Type: application/json');
        $insurerRepo = new InsurersRepo();
        if ($this->request->getRequestMethod() === 'GET' && $this->request->verifyIfIsset('name_insurer')) {  
            $services = $insurerRepo->getServicesBYInsurerName($this->request->getValue('name_insurer'));
            $jsonServices = json_encode($services);
            print_r($jsonServices);
        } else {
            echo 'Error';
        }
    }
    
    private function newInsurance(string $type)
    {   
        $typeRepo = new TypeRepo();
        $idType = $typeRepo->getIdByName($type);
        $insuranceEntity = new InsurancesEntity($idType[0]->id);
        $insuranceRepo = new InsuranceRepo();
        $insuranceRepo->insert($insuranceEntity);
    }
    private function newServiceInsurances(int $idServices, $price)
    {
        $idInsurances = $this->insuranceId();
        $serviceInsuranceEntity = new Service_insurancesEntity($idServices,$idInsurances[0]->id, $price);
        $serviceInsurancesRepo = new Service_insurancesRepo();
        $serviceInsurancesRepo->insert($serviceInsuranceEntity);
    } 

    private function newInsurerInsurances(string $insurerName)
    {
        $insurerRepo = new InsurersRepo();
        $idInsurances = $this->insuranceId();
        $idInsurer= $insurerRepo->getIdInsurerByInsurer($insurerName);
        $insurerInsurancesEntity = new Insurers_insurancesEntity($idInsurer[0]->id, $idInsurances[0]->id);
        $insurerInsurancesRepo = new Insurers_insurancesRepo();
        $insurerInsurancesRepo->insert($insurerInsurancesEntity);
    }

    private function insuranceId()
    {
        $insuranceRepo = new InsuranceRepo();
        $idInsurances = $insuranceRepo->LastInsurance();
        return $idInsurances;
    }

    private function validateObject(object $object)
    {
        $validater = new Validater();
        if ($validater->validate($object) != null) {
            $error = $validater->validate($object); 
            return $error;
        }
        return null;
    }

    private function verifyValues(string $type, string $insurer): array
    {
        $error = array();
        if ($type == 'Select type') {
                array_push($error ,'Select Type');
        }
        if ($insurer == 'Select insurer') {
                array_push($error ,'Select Insurer'); 
        }        
        return $error;
    }
    private function verifyCustomer(string $name)
    {
        $customerRepo= new CustomerRepo();
        if ($customerRepo->getId($name) == []) {
          return $name.' must be a customer';
        }
        return null;  
    }

    private function newInsuranceCustomer(string $customer ,string $insuranceType)
    {
        $idInsurances = $this->insuranceId();
        $customerRepo = new CustomerRepo();
        $idCustomer = $customerRepo->getId($customer);
        $insuranceCustomerRepo = new Insurances_customerRepo();
        $time= time();
        $start_time =date("Y-m-d H:i:s",$time);
        if ($insuranceType == 'Private') {
            $end_time = date("Y-m-d H:i:s", strtotime($start_time.'+ 1 months'));
        } else {
            $end_time = date("Y-m-d H:i:s", strtotime($start_time.'+ 3 months')); 
        }    
        $status = 'valabil';
        $insuranceCustomerEntity = new Insurances_customerEntity($idInsurances[0]->id, $idCustomer[0]->id,$start_time,$end_time,$status);
        $insuranceCustomerRepo ->insert($insuranceCustomerEntity);
    }

    private function verifyType($type, $customer)
    {
        $typeRepo = new TypeRepo();
        $insuranceRepo = new InsuranceRepo();
        $multipleId = $typeRepo->getMultiple($type);
        if ($multipleId) {
          if ($multipleId->multiple != 1) {
            $existing = $insuranceRepo->verifyInsuranceExisting($multipleId->id, $customer);
            if ($existing->Number >= 1) {
                return "A ".$type." insurance is already registered";
            }

          }
        }
    }

    private function add()
    {
        if ($this->request->getRequestMethod() == 'POST' && $this->request->verifyIfIsset('add')) {
           $type = $this->request->getValue('type_form');
           $customer=  $this->request->getValue('customer_form');
           if ($this->verifyType($type, $customer) !=null) {
                $error= array($this->verifyType($type, $customer));
                return $error;
            }
           $insurerName = $this->request->getValue('name_insurer');
           if ($this->request->verifyIfIsset('checkbox')) {
                   $checkbox=$this->request->getValue('checkbox');
           }
           if ($this->verifyCustomer($customer) !=null) {
               $error = array($this->verifyCustomer($customer));
               return $error;
           }
           $servicesRepo = new ServicesRepo();
           $customerEntity = new CustomerEntity($customer);
           if ($this->validateObject($customerEntity) == null && $this->verifyValues($type,$insurerName) ==[]) {
                $this->newInsurance($type);
                foreach ($checkbox as $service) {
                    $price = $servicesRepo->getPriceByName($service)[0]->price;
                    $idServices = $servicesRepo->getIdByName($service);
                    $this->newServiceInsurances($idServices[0]->id , $price);

                }
                $this->newInsurerInsurances($insurerName);
                $this->newInsuranceCustomer($customer,$type,$checkbox);
            } else {
                $error = $this->verifyValues($type,$insurerName);
                if ($this->validateObject($customerEntity)!=[]) {
                    foreach ($this->validateObject($customerEntity) as $err) {
                    array_push($error,$err);
                    }
                }
                return $error;
            }
        }

    }


    private function filter(): ?array
    {
        if ($this->request->getRequestMethod() === 'POST') {
            if ($this->request->verifyIfIsset('search')!=null || $this->request->verifyIfIsset('reset')!=null) {
                if ($this->request->getValue('search_box') !=null) {
                    $insuranceRepo = new InsuranceRepo();   
                    $sqlFilter = $insuranceRepo->sql;
                    $search = $this->request->getValue('search_box');
                    $sqlFilter  .=" where insurances_customer.status LIKE  '%{$search}%'";
                    if (strtotime($search)) {
                        $sqlFilter  .=" or insurances_customer.start_time LIKE '{$search}'";
                    }  
                    $sqlFilter  .=" or type.name LIKE  '%{$search}%'";
                    $sqlFilter .=" or customer.name LIKE  '%{$search}%'"; 
                    $query = $insuranceRepo->queryAndFetch( $sqlFilter );
                    return $query;
                }        
            }
        }
        return [];
    }


}
 

?>