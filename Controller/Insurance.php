<?php

namespace Controller;
require_once ('C:\xampp\htdocs\MedInsurance\autoloader.php');

use Views\View as View;
use Repository\Insurance as InsuranceRepo;



class Insurance{

    public function overview()
    {
       
        $repo = new InsuranceRepo;
        $view = new View();
        $view ->Overview($repo->findAll());
        
    }

}



?>