<?php

namespace Controller;

use Core\ControllerAbstract;
use Model\User as UserModel;

class User extends ControllerAbstract
{
    public function Register()
    {
        $this->twig->display('user_register.html.twig');
    }
    public function Create()
    {
        $notEmptyPass = $_POST['password1'] != '';
        $passMatch = $_POST['password1'] === $_POST['password2'];
        if ($passMatch){
            $hash = password_hash($_POST['password1'],PASSWORD_DEFAULT);
        }
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        $isValueUnique = new UserModel();
        $isValueUnique->checkEmail($_POST['email']);
        $isValueUnique->checkNickname($_POST['nickname']);
        if ($notEmptyPass && $passMatch && $isEmailValid) {
            $user = new UserModel();
            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setPassword($hash);
            $user->setEmail($email);
            $user->setRoleId(1);
            $user->setActive(1);
            $user->setNickname($_POST['nickname']);
            $user->save();

        }
    }

    public function login()
    {
        $this->twig->display('user_login.html.twig');

    }

    public function check()
    {
        $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $userId = new UserModel;
        $userId->checkLoginCredentials($email, $hash);
        $user = new UserModel();
        $user->load((int)$userId);
        $_SESSION['logged'] = true;
        $_SESSION['user_id'] = $userId;
        $_SESSION['user'] = $user;
        echo '<pre>';
        print_r($user);
    }

}