<?php
namespace Controller;

use \Helper\FormHelper;
use \Helper\Validator;
use \Model\User as UserModel;
class User
{
    public function show($id)
    {
        echo 'User controller ID: ' . $id;
    }

    public function register()
    {
        $form = new FormHelper('user/create', 'POST');
        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Vardas'
        ]);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email'
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Password'
        ]);
        $form->input([
            'name' => 'password2',
            'type' => 'password',
            'placeholder' => 'Password'
        ]);
        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'register'
        ]);

        echo $form->getForm();
    }

    public function login()
    {
        $form = new FormHelper('*', 'POST');
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email'
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Password'
        ]);
        $form->input([
            'name' => 'login',
            'type' => 'submit',
            'value' => 'login'
        ]);

        echo $form->getForm();
    }
    public function create()
    {
       $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
       $isEmailValid = Validator::checkEmail($_POST['email']);
       $isEmailUniq = UserModel::emailUniq($_POST['email']);
       if($passMatch && $isEmailValid && $isEmailUniq){

       }
       print_r($_POST);
    }
}