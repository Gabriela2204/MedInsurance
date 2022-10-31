<?php

namespace App\Controller;


use App\Views\View as View;
use App\Repository\Customer as CustomerRepo;


class Customer{

    public function addNewCustomer()
    {

        $view = new View();
        $view ->AddNewCustomer();
        $repo = new CustomerRepo;
        $repo->add();
    
        
    }

}



?>