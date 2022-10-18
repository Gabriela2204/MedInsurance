<?php
namespace Views;
require_once ('C:\xampp\htdocs\MedInsurance\vendor\autoload.php');
use Twig\Loader\FilesystemLoader as FilesystemLoader;

class View {

    public function Overview($data){
    //    print_r($data);
       $data = array("Infos" =>$data);
        $loader = new FilesystemLoader('C:\xampp\htdocs\MedInsurance\Layouts');
        $twig = new \Twig\Environment($loader);
        echo $twig->render('Overview.twig',$data);
    } 


}

?>