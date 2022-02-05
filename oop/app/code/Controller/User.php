<?php

namespace Controller;

use Helper\DBHelper;
use Helper\FormHelper;
use Helper\Validator;
use Helper\Url;
use Model\User as UserModel;
use Model\City;

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
            'name' => 'last_name',
            'type' => 'text',
            'placeholder' => 'Pavarde'
        ]);
        $form->input([
            'name' => 'phone',
            'type' => 'tel',
            'placeholder' => 'telefonas'
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
        $cities = City::getCities();
        $options = [];
        foreach ($cities as $city) {
            $id = $city->getId();
            $options[$id] = $city->getName();
        }
        $form->select(['name' => 'city_id', 'options' => $options]);

        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'register'
        ]);

        echo $form->getForm();
    }

    public function login()
    {
        $form = new FormHelper('user/check', 'POST');
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
        if ($passMatch && $isEmailValid && $isEmailUniq) {
            $user = new UserModel();
            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setPhone($_POST['phone']);
            $user->setPassword(md5($_POST['password']));
            $user->setEmail($_POST['email']);
            $user->setCityId($_POST['city_id']);
            $user->save();
            Url::redirect('user/login');
        }else{
            echo 'Patikrinkite duomenis';
        }

    }
    public function edit()
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }else{
            $userId = $_SESSION['user_id'];
            $user = new UserModel();
            $user->load($userId);
            $form = new FormHelper('user/update', 'POST');
            $form->input([
                'name' => 'name',
                'type' => 'text',
                'placeholder' => 'Vardas',
                'value' => $user->getName()
            ]);
            $form->input([
                'name' => 'last_name',
                'type' => 'text',
                'placeholder' => 'Pavardė',
                'value' => $user->getLastName()
            ]);
            $form->input([
                'name' => 'phone',
                'type' => 'tel',
                'placeholder' => 'Telefonas',
                'value' => $user->getPhone()
            ]);
            $form->input([
                'name' => 'email',
                'type' => 'email',
                'placeholder' => 'El. paštas',
                'value' => $user->getEmail()
            ]);
            $form->input([
                'name' => 'password',
                'type' => 'password',
                'placeholder' => 'Slaptažodis'
            ]);
            $form->input([
                'name' => 'password2',
                'type' => 'password',
                'placeholder' => 'Pakartoti slaptažodį'
            ]);
            $cities = City::getCities();
            $options = [];
            foreach ($cities as $city) {
                $id = $city->getId();
                $options[$id] = $city->getName();
            }
            $form->select([
                'name' => 'city_id',
                'options' => $options,
                'selected' => $user->getCityId()
            ]);
            $form->input([
                'name' => 'create',
                'type' => 'submit',
                'value' => 'Atnaujinti'
            ]);

            echo $form->getForm();

        }
    }

    public function update()
    {
            $userId = $_SESSION['user_id'];
            $user = new UserModel();
            $user->load($userId);

            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setPhone($_POST['phone']);
            $user->setCityId($_POST['city_id']);

            if($_POST['password'] != '' && Validator::checkPassword($_POST['password'], $_POST['password2'])){
                $user->setPassword(md5($_POST['password']));
            }
            if($user->getEmail() != $_POST['email']){
                if(Validator::checkEmail($_POST['email']) && UserModel::emailUniq($_POST['email'])){
                    $user->setEmail($_POST['email']);
                }
            }
            $user->save();
            Url::redirect('user/edit');

    }

    public function check()
    {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $userId = UserModel::checkLoginCredentials($email, $password);
        if($userId){
            $user = new UserModel();
            $user->load($userId);
            $_SESSION['user_id'] = $userId;
            $_SESSION['user'] = $user;
            Url::redirect('user/edit');
        }else{
            echo 'Patikrinkite duomenis';
            Url::redirect('user/login');
        }
    }
    public function logout()
    {
        session_destroy();
    }
}