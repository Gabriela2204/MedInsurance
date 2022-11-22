<?php
namespace App\Views;
use Twig\Loader\FilesystemLoader as FilesystemLoader;

class View
{
  public function Overview(array $data, array $filter = Null)
  {
    $data = array("Infos" =>$data);
    if ($filter != [])
      $data["Infos"] = $filter;
    $loader = new FilesystemLoader('C:\xampp1\htdocs\MedInsurance\src\Layouts');
    $twig = new \Twig\Environment($loader);
    echo $twig->render('Overview.twig',$data);
  } 

  public function AddNewCustomer(array $errors = Null)
  {
    $loader = new FilesystemLoader('C:\xampp1\htdocs\MedInsurance\src\Layouts');
    $errors = array("Errors" => $errors);
    $twig = new \Twig\Environment($loader);
    echo $twig->render('AddNewCustomer.twig', $errors);
  }

  public function AddNewInsurance(array $names, array $types, array $error=null)
  {
    $data = array("Names" =>$names);
    $data['Errors'] = $error;
    $data['Types'] = $types;
    $loader = new FilesystemLoader('C:\xampp1\htdocs\MedInsurance\src\Layouts');
    $twig = new \Twig\Environment($loader);
    echo $twig->render('AddNewInsurance.twig',$data);
  }

  public function CustomerOverview(array $data)
  {
    $data = array("Infos" =>$data);
    $loader = new FilesystemLoader('C:\xampp1\htdocs\MedInsurance\src\Layouts');
    $twig = new \Twig\Environment($loader);
    echo $twig->render('CustomerOverview.twig',$data);
  }
   
  public function ViewDetails(array $data = null)
  {
    $data = array("Infos" =>$data);
    $loader = new FilesystemLoader('C:\xampp1\htdocs\MedInsurance\src\Layouts');
    $twig = new \Twig\Environment($loader);
    echo $twig->render('ViewDetails.twig',$data);
  }

  public function AddNewUser(array $errors = null)
  {
    $errors = array("Errors" => $errors);
    $loader = new FilesystemLoader('C:\xampp1\htdocs\MedInsurance\src\Layouts');
    $twig = new \Twig\Environment($loader);
    echo $twig->render('AddNewUser.twig',$errors);
  }
}

?>