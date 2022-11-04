<?php

namespace App\Controller;


use App\Views\View as View;
use App\Repository\Insurances as InsuranceRepo;
use App\Repository\Insurers as Insurers;


class Insurance extends BaseController{

    public function overview()
    {
       
        $repo = new InsuranceRepo;
        $view = new View();
        $view ->Overview($repo->AllInfo(),$this->filter());
       
    
        
    }

    public function addNewInsurance()
    {
        $currentInsurers = $this->InsurerServices();
        $service = new Insurers;
        $services = $service->getServices($currentInsurers[0]->id);
        print_r($services);// am nevoie de id ca sa caut serviciile in functie de insurer
        $view = new View();
        $view ->addNewInsurance();
    }

    public function filter(): ?array{
          
        if($this->request->getRequestMethod() === 'POST'){
              if( $this->request->getValue('search')!=null || $this->request->getValue('reset')!=null ){

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