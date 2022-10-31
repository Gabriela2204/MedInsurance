<?php
namespace App\Views;
use Twig\Loader\FilesystemLoader as FilesystemLoader;

class View {

    public function Overview($data,$filter){
        
       $data = array("Infos" =>$data);
       $data["filters"] = $filter;
        $loader = new FilesystemLoader('C:\xampp\htdocs\MedInsurance\src\Layouts');
        $twig = new \Twig\Environment($loader);
        echo $twig->render('Overview.twig',$data);
    } 


}

?>