<?php

namespace App\Controller;

use App\Entity\User as UserEntity;
use App\Repository\User as UserRepo;
use App\Validater;
use App\Views\View;
use App\Configuration;

class Login extends BaseController
{
    public function login()
    {   
        $config = new Configuration();
        if($this->session->verifyIfIsset('user')){
            header("Location:".$config->getConstantByKey('mainPage'));
            exit();
        }
        $error = array();
        if ($this->request->getRequestMethod() == 'POST' && $this->request->getValue('Login')) {
            $userRepo= new UserRepo();
            $userEntity = new UserEntity($this->request->getValue('Email_form'), $this->request->getValue('Password_form'));
            $valid = new Validater();
            if ($valid->validate($userEntity) != null) {
                $error = $valid->validate($userEntity);
            }
            if($this->request->getValue('Password_form') != null && $this->request->getValue('Email_form')!= null){
                if ($userRepo->getPassword($this->request->getValue('Email_form'))!=[] ){
                    if (password_verify( $this->request->getValue('Password_form') , $userRepo->getPassword($this->request->getValue('Email_form'))->password )) {
                        $this->session->setValue('user', $userRepo->getUserByEmail($this->request->getValue('Email_form')));
                        header("Location:".$config->getConstantByKey('mainPage'));
                        exit();
                    } else {
                        array_push($error, "Email doesn't match password");
                    }
                } else {
                    array_push($error,"Email doesn't exist");
                }
            }
        }
        $view = new View;
        $view->LoginPage($error);
    }
}

?>