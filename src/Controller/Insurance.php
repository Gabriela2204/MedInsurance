<?php

namespace App\Controller;


use App\Views\View as View;
use App\Repository\Insurances as InsuranceRepo;
use App\Repository\Insurers as Insurers;


class Insurance{

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

    public function filter(): array{
        session_start();
           
        
              if(isset($_POST['search']) || isset($_POST['reset'])){
                 
                 if(isset($_POST['search']))
                 {
                 $search_term= $_POST['search_box'];
                 $_SESSION['search_box'] = $search_term;
                 }
                 else 
                 return [];
  
                 header('Location: index.php?controller=Insurance&action=overview');
                 exit;
        
              
              }
              $sqlFilter = $this->sql;
              if (isset($_SESSION['search_box'])) {
                 $search = $_SESSION['search_box'];
                 $sqlFilter  .=" where insurances_customer.status LIKE  '%{$search}%'";
                 if(strtotime($search)) {
                    echo strtotime($search);
                    $sqlFilter  .=" or insurances_customer.start_time LIKE '{$search}'";
                 }
                 
                 $sqlFilter  .=" or type.name LIKE  '%{$search}%'";
                 $sqlFilter .=" or customer.name LIKE  '%{$search}%'";
                 $repo = new InsuranceRepo;
                 $query = $repo->queryAndFetch( $sqlFilter ); 
                 unset($_SESSION['search_box']);
                 return $query;
             }
             else return [];
      }

      public function InsurerServices(): array{
        session_start();
           
        
              if(isset($_POST['Services']) && isset($_POST['insurer_form'])){
                 
                 echo "sunt in if";
                 $insurer= $_POST['insurer_form'];
                 $_SESSION['insurer_form'] = $insurer;
  
                 header('Location: index.php?controller=Insurance&action=AddNewInsurance');
                 exit;
        
              
              }
              if (isset($_SESSION['insurer_form'])) {
                 $insurer = $_SESSION['insurer_form'];
                 $repo = new InsuranceRepo;
                return $repo->queryAndFetch("Select id from insurers where name = '{$insurer}'");
  
                 unset($_SESSION['insurer_form']);
        
             }
             else return [];
      }

}



?>