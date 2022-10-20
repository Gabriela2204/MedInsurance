<?php

namespace App\Controller;

use App\Views\View as View;
use App\Repository\Insurance as InsuranceRepo;


class Insurance{

    public function overview()
    {
       
        $repo = new InsuranceRepo;
        $view = new View();
        $view ->Overview($repo->AllInfo('insurances'));
    
        
    }

}



?>