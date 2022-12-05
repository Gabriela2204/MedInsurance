<?php

namespace App\Controller;

use App\Entity\User as EntityUser;
use App\Repository\User;
use App\Validater;
use App\Views\View;
use App\Configuration;

class Login extends BaseController
{
    public function login()
    {   
        $config = new Configuration();
        if($this->session->verifyIfIsset('email')){
            header("Location:".$config->getConstantByKey('mainPage'));
            exit();
        }
        $error = array();
        if ($this->request->getRequestMethod() == 'POST' && $this->request->getValue('Login')) {
            $repoUser = new User();
            $user = new EntityUser($this->request->getValue('Email_form'), $this->request->getValue('Password_form'));
            $valid = new Validater();
            if ($valid->validate($user) != null) {
                $error = $valid->validate($user);
            }
            if($this->request->getValue('Password_form') != null && $this->request->getValue('Email_form')!= null){
                if ($repoUser->searchEmailPassword($this->request->getValue('Email_form'))!=[] ){
                    if (password_verify( $this->request->getValue('Password_form') , $repoUser->searchEmailPassword($this->request->getValue('Email_form'))[0]->password )) {
                        $this->session->setValue('email', $this->request->getValue('Email_form'));
                        $this->session->setValue('password', $this->request->getValue('Password_form'));
                        header("Location:".$config->getConstantByKey('mainPage'));
                        exit();
                    } else {
                        array_push($error, "Email doesn't match password");
                    }
                }
            }
        }
        $view = new View;
        $view->LoginPage($error);
    }
}

?>