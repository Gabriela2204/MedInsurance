<?php

namespace App\Controller;


use App\Views\View as View;
use App\Repository\Insurances as InsuranceRepo;


class Insurance{

    public function overview()
    {
       
        $repo = new InsuranceRepo;
        $filter = $repo->filter();
        $view = new View();
        $view ->Overview($repo->AllInfo(), $filter);
    
        
    }

}



?>