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
    $loader = new FilesystemLoader(json_decode(file_get_contents('src\Constants.json'), true)['fileSystemLoader']);
    $twig = new \Twig\Environment($loader);
    echo $twig->render('Overview.twig',$data);
  } 

  public function AddNewCustomer(array $errors = Null)
  {
    $loader = new FilesystemLoader(json_decode(file_get_contents('src\Constants.json'), true)['fileSystemLoader']);
    $errors = array("Errors" => $errors);
    $twig = new \Twig\Environment($loader);
    echo $twig->render('AddNewCustomer.twig', $errors);
  }

  public function AddNewInsurance(array $names, array $types, array $error=null)
  {
    $data = array("Names" =>$names);
    $data['Errors'] = $error;
    $data['Types'] = $types;
    $loader = new FilesystemLoader(json_decode(file_get_contents('src\Constants.json'), true)['fileSystemLoader']);
    $twig = new \Twig\Environment($loader);
    echo $twig->render('AddNewInsurance.twig',$data);
  }

  public function CustomerOverview(array $data)
  {
    $data = array("Infos" =>$data);
    $loader = new FilesystemLoader(json_decode(file_get_contents('src\Constants.json'), true)['fileSystemLoader']);
    $twig = new \Twig\Environment($loader);
    echo $twig->render('CustomerOverview.twig',$data);
  }
   
  public function ViewDetails(array $data = null)
  {
    $data = array("Infos" =>$data);
    $loader = new FilesystemLoader(json_decode(file_get_contents('src\Constants.json'), true)['fileSystemLoader']);
    $twig = new \Twig\Environment($loader);
    echo $twig->render('ViewDetails.twig',$data);
  }

  public function AddNewUser(array $errors = null, int $admin = null)
  {
    $info = array("Errors" => $errors);
    $info['Admin'] = $admin;
    $loader = new FilesystemLoader(json_decode(file_get_contents('src\Constants.json'), true)['fileSystemLoader']);
    $twig = new \Twig\Environment($loader);
    echo $twig->render('AddNewUser.twig',$info);
  }
  public function LoginPage(array $errors = null)
  { 
    $errors = array("Errors" => $errors);
    $loader = new FilesystemLoader(json_decode(file_get_contents('src\Constants.json'), true)['fileSystemLoader']);
    $twig = new \Twig\Environment($loader);
    echo $twig->render('Login.twig', $errors);
  }
}

?>