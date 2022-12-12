<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\User as UserEntity;
use App\Repository\Insurances as InsurancesRepo;
use App\Repository\User as UserRepo;
use App\Views\View;
use App\Validater;

class User extends BaseController
{

  public function verifyEmail()
  {
    $userRepo = new UserRepo();
    if ($userRepo->verifyEmail($this->request->getValue('email_form'))[0]->number != 0) {
      return array("Email is already registered");
    }
  }
  public function adminOption()
  {
    if ($this->request->getValue('admin_form') == 'True') {
      $admin = 1;        
    } else {
      $admin = 0;
    }
    return $admin;
  }
  public function add()
  {
      $error = array();
      if ($this->request->getRequestMethod() == 'POST' && $this->request->getValue('add')) {
        if ($this->verifyEmail() != []) {
          return $this->verifyEmail();
        }
        if($this->request->getValue('confirm_password_form') != $this->request->getValue('password_form')) {
          array_push($error ,"Passwords don't match");
          return $error;
        }
        $admin = $this->adminOption();
        $password = $this->request->getValue('password_form');
        if ($this->request->getValue('password_form') != null) {
          $password = password_hash($this->request->getValue('password_form'), PASSWORD_DEFAULT);
        }
        $idInsurer = $this->session->getValue('user')->id_insurer;
        $user = new UserEntity( $this->request->getValue('email_form'), $password,$idInsurer,$this->request->getValue('name_form'), $admin);
        $valid = new Validater();
        if ($valid->validate($user) == null) {
          $userRepo = new UserRepo();
          $userRepo->insert($user);
        }
          $error1 = $valid->validate($user);
          return $error1;
      }

  }

  public function addNewUser()
  {
    $this->verifySession();
    $view = new View();
    $admin = $this->session->getValue('user')->is_admin;
    if ($admin == 0) {
      array_push($error ,"You can not add a new user because you are not an admin.");
      $view->AddNewUser($error,$admin);
    } else {

          $view->AddNewUser($this->add());
      }
    }
}

?>