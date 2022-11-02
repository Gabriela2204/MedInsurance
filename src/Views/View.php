<?php
namespace App\Views;
use Twig\Loader\FilesystemLoader as FilesystemLoader;

class View {

    public function Overview(array $data, array $filter = Null){
        
       $data = array("Infos" =>$data);
       if($filter != [])
         $data["Infos"] = $filter;
       $loader = new FilesystemLoader('C:\xampp\htdocs\MedInsurance\src\Layouts');
       $twig = new \Twig\Environment($loader);
       echo $twig->render('Overview.twig',$data);
    } 

    public function AddNewCustomer(){

        $loader = new FilesystemLoader('C:\xampp\htdocs\MedInsurance\src\Layouts');
        $twig = new \Twig\Environment($loader);
        echo $twig->render('AddNewCustomer.twig');
    }

    public function AddNewInsurance(){
        $loader = new FilesystemLoader('C:\xampp\htdocs\MedInsurance\src\Layouts');
        $twig = new \Twig\Environment($loader);
        echo $twig->render('AddNewInsurance.twig');

    }

}

?>