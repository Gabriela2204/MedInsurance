<?php
namespace App\Entity;
class Insurances_customer{
        

    public $id_insurances;
    public $id_customer;
    public $pricing;
    public $start_time;
    public $end_time;
    public $status;

    public function __construct( $id_insurances = NULL , $id_customer = NULL,$pricing = NULL, $start_time = NULL ,$end_time = NULL ,$status = NULL  ){

      $this->id_insurances = $id_insurances;
      $this->id_customer = $id_customer;
      $this->pricing = $pricing;
      $this->start_time = $start_time;
      $this->end_time = $end_time;
      $this->status = $status;
    }


}

?>