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

    public function AddNewCustomer(string $errors = Null){
        $loader = new FilesystemLoader('C:\xampp\htdocs\MedInsurance\src\Layouts');
        $errors = array("Error" => $errors);
        $twig = new \Twig\Environment($loader);
        echo $twig->render('AddNewCustomer.twig', $errors);
    }

    public function AddNewInsurance(array $names,array $services = Null){
        $data = array("Names" =>$names);
        $data["Services"] = $services;
        $loader = new FilesystemLoader('C:\xampp\htdocs\MedInsurance\src\Layouts');
        $twig = new \Twig\Environment($loader);
        echo $twig->render('AddNewInsurance.twig',$data);

    }

}

?>