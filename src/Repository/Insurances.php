<?php
   namespace App\Repository;
   

   class Insurances extends BaseRepository{
    
      private $sql= "select insurances.id, insurances_customer.pricing ,insurances_customer.id_insurances as ID,
      insurances_customer.start_time, insurances_customer.status, type.name as Type, customer.name as Client from insurances
      inner join insurances_customer on insurances.id = insurances_customer.id_insurances
      inner join type on insurances.id_type = type.id
      inner join customer on customer.id =  insurances_customer.id_customer ";

    public function filter(){
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
               $query = $this->queryAndFetch( $sqlFilter ); 
               unset($_SESSION['search_box']);
               return $query;
           }


    }
    public function AllInfo(){
          
          return $this->queryAndFetch( $this->sql);
    }
    
 
   }
 


?>