<?php

namespace Controller;

use Core\AbstractController;
use Helper\FormHelper;
use Helper\Url;
use Helper\Validator;
use Model\City;
use Model\User as UserModel;

class User extends AbstractController
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

//        return ['page_content' => $form->getForm()];
        $this->data['form'] = $form->getForm();
        $this->render('user/register');
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

        return ['page_content' => $form->getForm()];
//        $this->data['form'] = $form->getForm();
//        $this->render('user/login');
    }

    public function create()
    {
        $notEmptyPass = $_POST['password'] != '';
        $passMatch = $_POST['password'] === $_POST['password2'];
        $isEmailValid = Validator::checkEmail($_POST['email']);
        $isEmailUniq = UserModel::emailUniq($_POST['email']);
        if ($notEmptyPass && $passMatch && $isEmailValid && $isEmailUniq) {
            $user = new UserModel();
            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setPhone($_POST['phone']);
            $user->setPassword($_POST['password']);
            $user->setEmail($_POST['email']);
            $user->setCityId($_POST['city_id']);
            $user->save();
            Url::redirect('user/login');
        }

    }

    public function edit()
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        } else {
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
                'placeholder' => 'Pavard??',
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
                'placeholder' => 'El. pa??tas',
                'value' => $user->getEmail()
            ]);
            $form->input([
                'name' => 'password',
                'type' => 'password',
                'placeholder' => 'Slapta??odis'
            ]);
            $form->input([
                'name' => 'password2',
                'type' => 'password',
                'placeholder' => 'Pakartoti slapta??od??'
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

            return ['page_content' => $form->getForm()];
//            $this->data['form'] = $form->getForm();
//            $this->render('user/edit');
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

        if ($_POST['password'] != '' && $_POST['password'] === $_POST['password2']) {
            $user->setPassword($_POST['password']);
        }
        if ($user->getEmail() != $_POST['email']) {
            if (Validator::checkEmail($_POST['email']) && UserModel::emailUniq($_POST['email'])) {
                $user->setEmail($_POST['email']);
            }
        }
        $user->save();
        Url::redirect('user/edit');

    }

    public function check()
    {
        $email = $_POST['email'];
        $user = UserModel::loadByUsername($email);
        if ($user !== null && Validator::checkPassword($_POST['password'], $user->getPassword())) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user'] = $user;
            Url::redirect('user/edit');
        } else {
            Url::redirect('user/login');
        }
    }

    public function logout()
    {
        session_destroy();
    }

    public function all()
    {
        $this->data['users'] = UserModel::getAllUsers();
//        $this->render('user/list');
        return ['page_content' => $this->data['users']];
    }
}