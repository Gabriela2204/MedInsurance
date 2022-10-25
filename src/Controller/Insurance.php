<?php

namespace App\Controller;


use App\Views\View as View;
use App\Repository\Insurances as InsuranceRepo;


class Insurance{

    public function overview()
    {
       
        $repo = new InsuranceRepo;
        $view = new View();
        $view ->Overview($repo->AllInfo());
    
        
    }

}



?>