<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\User as EntityUser;
use App\Repository\User as RepositoryUser;
use App\Views\View;
use App\Validater;

class User extends BaseController
{

  public function verifyEmail()
  {
    $userRepo = new RepositoryUser;
    if ($userRepo->searchEmail($this->request->getValue('email_form'))[0] ->number != 0) {
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
      if ($this->request->getRequestMethod() == 'POST' && $this->request->getValue('add')) {
        if ($this->verifyEmail() != []) {
          return $this->verifyEmail();
        }
        $admin = $this->adminOption();
        $password = $this->request->getValue('password_form');
        if ($this->request->getValue('password_form') != null) {
          $password = password_hash($this->request->getValue('password_form'), PASSWORD_DEFAULT);
        }
        
        $user = new EntityUser(2,$this->request->getValue('name_form'), $this->request->getValue('email_form'), $password, $admin);
        $valid = new Validater;
        if ($valid->validate($user) == null) {
          $repo = new RepositoryUser;
          $repo->insert($user);
        }
          $error = $valid->validate($user);
          return $error;
      }

  }

  public function addNewUser()
  {
    $view = new View();
    $view->AddNewUser($this->add());
  }
}

?>