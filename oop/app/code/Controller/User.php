<?php
declare(strict_types=1);

namespace Controller;

use Core\Interfaces\ControllerInterface;
use Helper\DBHelper;
use Helper\FormHelper;
use Helper\Validator;
use Helper\Url;
use Model\City;
use Model\User as UserModel;
use Core\AbstractController;

class User extends AbstractController implements ControllerInterface
{
    public function index(): void
    {
        $this->data['users'] = UserModel::getAllUsers();
        $this->render('user/list');
    }
    public function show($id)
    {
        echo 'User controller ID: ' . $id;
    }

    public function register(): void
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
            'placeholder' => 'Pavardė'
        ]);
        $form->input([
            'name' => 'phone',
            'type' => 'text',
            'placeholder' => 'Telefonas'
        ]);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'El. paštas'
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
        $form->select(['name' => 'city_id', 'options' => $options]);
        $form->input([
            'name' => 'active',
            'type' => 'checkbox',
            'label' => 'Aktyvus',
        ]);
        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'register'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('user/register');
    }

    public function edit(): void
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

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
            'type' => 'text',
            'placeholder' => '+3706*******',
            'value' => $user->getPhone()
        ]);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email',
            'value' => $user->getEmail()
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'slaptažodis'
        ]);
        $form->input([
            'name' => 'password2',
            'type' => 'password',
            'placeholder' => 'pakartoti sla[tažodį'
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
            'name' => 'active',
            'type' => 'checkbox',
            'label' => 'Aktyvus',
        ]);

        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Redaguoti'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('user/edit');

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
        isset($_POST['active']);
        $user->setActive((bool)1);

        if ($_POST['password'] != '' && Validator::checkPassword($_POST['password'], $_POST['password2'])) {
            $user->setPassword(md5($_POST['password']));
        }

        if ($user->getEmail() != $_POST['email']) {
            if (Validator::checkEmail($_POST['email']) && UserModel::valueUniq('email', $_POST['email'], 'users')) {
                $user->setEmail($_POST['email']);
            }
        }

        $user->save();
        Url::redirect('catalog');
    }

    public function login(): void
    {
        $form = new FormHelper('user/check', 'POST');
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'El. paštas'
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'slaptažodis'
        ]);
        $form->input([
            'name' => 'login',
            'type' => 'submit',
            'value' => 'Prisijungti'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('user/login');
    }

    public function create(): void
    {
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $isEmailValid = Validator::checkEmail($_POST['email']);
        $isEmailUniq = UserModel::valueUniq('email',$_POST['email'], 'users');
        if ($passMatch && $isEmailValid && $isEmailUniq) {
            $user = new UserModel();
            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setPhone($_POST['phone']);
            $user->setPassword(md5($_POST['password']));
            $user->setEmail($_POST['email']);
            $user->setCityId($_POST['city_id']);
            $user->setRoleId(0);
            isset($_POST['active']);
            $user->setActive(1);
            $user->save();
            Url::redirect('user/login');
        } else {
            echo 'Patikrinkite duomenis';
        }
    }

    public function check(): void
    {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $userId = UserModel::checkLoginCredentials($email, $password);
        if ($userId) {
            $user = new UserModel();
            $user->load((int)$userId);
            $_SESSION['logged'] = true;
            $_SESSION['user_id'] = $userId;
            $_SESSION['user'] = $user;
            Url::redirect('/');
        } else {

            Url::redirect('user/login');
        }
    }

    public function logout(): void
    {
        session_destroy();
    }


}
