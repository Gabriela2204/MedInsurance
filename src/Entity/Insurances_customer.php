<?php
namespace App\Entity;
class Insurances_customer{
        

    public int $id_insurances;
    public int $id_customer;
    public float $pricing;
    public string $start_time;
    public string $end_time;
    public string $status;

    public function __construct(int $id_insurances = NULL , int $id_customer = NULL,float $pricing = NULL, string $start_time = NULL ,string $end_time = NULL ,string $status = NULL  ){

      $this->id_insurances = $id_insurances;
      $this->id_customer = $id_customer;
      $this->pricing = $pricing;
      $this->start_time = $start_time;
      $this->end_time = $end_time;
      $this->status = $status;
    }


}

?>