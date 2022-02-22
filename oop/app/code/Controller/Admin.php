<?php

namespace Controller;

use Core\AbstractController;
use Helper\FormHelper;
use Helper\Url;
use Helper\Validator;
use Model\Ad;
use Model\City;
use Model\Manufacturer;
use Model\Model;
use Model\Type;
use Model\User as UserModel;


class Admin extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->isUserAdmin()) {
            Url::redirect('');
        }
    }

    public function index()
    {
        $this->renderAdmin('index');
    }

    public function users()
    {
        $this->data['users'] = UserModel::getAllUsers();
        $this->renderAdmin('users/list');
    }
    public function userEdit($userId)
    {

        $user = new UserModel();
        $user->load($userId);

        $form = new FormHelper('admin/userUpdate', 'POST');
        $form->input([
            'name' => 'id',
            'type' => 'hidden',
            'value' => $user->getId()
        ]);
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
        $form->select([
            'name' => 'active',
            'options' => [0 => 'neaktyvus', 1 => 'aktyvus'],
        ]);

        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Redaguoti'
        ]);

        $this->data['form'] = $form->getForm();
        $this->renderAdmin('users/useredit');

    }
    public function userUpdate()
    {
        $userId = $_POST['id'];
        $user = new UserModel();
        $user->load($userId);

        $user->setName($_POST['name']);
        $user->setLastName($_POST['last_name']);
        $user->setPhone($_POST['phone']);
        $user->setCityId($_POST['city_id']);
        $user->setActive($_POST['active']);

        if ($user->getEmail() != $_POST['email']) {
            if (Validator::checkEmail($_POST['email']) && UserModel::valueUniq('email', $_POST['email'], 'users')) {
                $user->setEmail($_POST['email']);
            }
        }

        $user->save();
        Url::redirect('admin/users');
    }
    public function ads()
    {
        $this->data['ads'] = Ad::getAllAds();
        $this->renderAdmin('catalog/list');
    }
    public function  adEdit($id)
    {

        $ad = new Ad();
        $ad->load($id);


        $form = new FormHelper('admin/adUpdate', 'POST');
        $form->input([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Pavadinimas',
            'value' => $ad->getTitle()
        ]);

        $form->input([
            'name' => 'id',
            'type' => 'hidden',
            'value' => $ad->getId()

        ]);

        $form->textArea('description', $ad->getDescription());
        $form->input([
            'name' => 'price',
            'type' => 'number',
            'step' => '0.01',
            'placeholder' => 'Kaina',
            'value' => $ad->getPrice()
        ]);
        $manufacturers = Manufacturer::getManufacturers();
        $options = [];
        foreach ($manufacturers as $manufacturer) {
            $id = $manufacturer->getId();
            $options[$id] = $manufacturer->getManufacturer();
        }
        $form->select(['name' => 'manufacturer_id', 'options' => $options, 'value' => $ad->getManufacturerId()]);
        $models = Model::getModels();
        $options = [];
        foreach ($models as $model) {
            $id = $model->getId();
            $options[$id] = ['model' => $model->getModel(), 'manufacturerId' => $model->getManufacturerId()];
        } ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="text/javascript">
            jQuery(function () {
                $('select[name="manufacturer_id"]').on('change', function () {


                    let modelSelect = $('select[name="model_id"]');
                    let manufacturerId = $(this).val();

                    modelSelect.find('option').hide();
                    modelSelect.find('option[data-manufacturer-id="' + manufacturerId + '"]').show().first().attr('selected', 'selected');

                    modelSelect.change();
                }).change();
            });
        </script>
        <?php $form->selectModel($options);
        $form->input([
            'name' => 'year',
            'type' => 'text',
            'placeholder' => 'Metai',
            'value' => $ad->getYear()
        ]);
        $types = Type::getTypes();
        $options = [];
        foreach ($types as $type) {
            $id = $type->getId();
            $options[$id] = $type->getType();
        }

        $form->select(['name' => 'type_id', 'options' => $options]);
        $form->input([
            'name' => 'image',
            'type' => 'url',
            'placeholder' => 'https://nuotraukosnuoroda.lt',
            'pattern' => 'https://.*',
            'value' => $ad->getPictureUrl()
        ]);
        $form->input([
            'name' => 'vin',
            'type' => 'text',
            'placeholder' => 'VIN',
            'value' => $ad->getVin()
        ]);
        $form->select([
            'name' => 'active',
            'options' => [0 => 'neaktyvus', 1 => 'aktyvus'],
        ]);
        $form->input([
            'type' => 'submit',
            'value' => 'Redaguoti',
            'name' => 'create'
        ]);
        $this->data['form'] = $form->getForm();
        $this->renderAdmin('catalog/adedit');
    }
    public function adUpdate()
    {

        $adId = $_POST['id'];
        $ad = new Ad();
        $ad->load($adId);
        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setVin(($_POST['vin']));
        $ad->setManufacturerId($_POST['manufacturer_id']);
        $ad->setModelId($_POST['model_id']);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId($_POST['type_id']);
        $ad->setPictureUrl($_POST['image']);
        $ad->setActive($_POST['active']);

        $ad->save();
        Url::redirect('admin/ads');
    }
    public function changeUserStatus()
    {
        $action = $_POST['action'];
        unset($_POST['action']);

        if ($action == 'Deaktyvuoti'){
            foreach ($_POST as $key => $value) {
                $ad = new UserModel($key);
                $ad->setActive(0);
                $ad->save();
            }
        }elseif($action == 'Aktyvuoti'){
            foreach ($_POST as $key => $value) {
                $ad = new UserModel($key);
                $ad->setActive(1);
                $ad->save();
            }
        }
        Url::redirect('admin/users');
    }
    public function changeAdStatus()
    {
        $action = $_POST['action'];
        unset($_POST['action']);

        if ($action == 'Deaktyvuoti'){
            foreach ($_POST as $key => $value) {
                $ad = new Ad($key);
                $ad->setActive(0);
                $ad->save();
            }
        }elseif($action == 'Aktyvuoti'){
            foreach ($_POST as $key => $value) {
                $ad = new Ad($key);
                $ad->setActive(1);
                $ad->save();
            }
        }
        Url::redirect('admin/ads');
    }
}
