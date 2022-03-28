<?php

namespace Controller;

use Core\AbstractController;
use Helper\FormHelper;
use Helper\Url;
use Model\Ad;
use Model\Manufacturer;
use Model\Model;
use Model\Type;
use Model\User as UserModel;

class Catalog extends AbstractController
{
    public function show($id)
    {
        if ($id !== null) {
            echo 'Catalog controller ID ' . $id;
        }
    }

//    public function all.php()
//    {
//        $content = '';
//        for ($i = 0; $i < 10; $i++) {
//            $content .= '<a href="http://localhost/pamokos/oop/index.php/catalog/show/' . $i . '">Read more</a>';
//            $content .= '<br>';
//        }
//
//        return ['page_content' => $content];
//    }
    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        } else {
            $userId = $_SESSION['user_id'];
            $user = new UserModel();
            $user->load($userId);
            $form = new FormHelper('catalog/create', 'POST');
            $form->input([
                'name' => 'title',
                'type' => 'text',
                'placeholder' => 'Pavadinimas'
            ]);
            $form->textArea('desc', 'Aprašymas');

            $manufacturers = Manufacturer::getManufacturers();
            $options = [];
            foreach ($manufacturers as $manufacturer) {
                $id = $manufacturer->getId();
                $options[$id] = $manufacturer->getManufacturer();
            }
            $form->select(['name' => 'manufacturer_id', 'options' => $options]);
            $models = Model::getModels();
            $options = [];
            foreach ($models as $model) {
                $id = $model->getId();
                $options[$id] = ['model' => $model->getModel(), 'manufacturerId' => $model->getManufacturerId()];
            }

            $form->selectModel($options);

            $form->input([
                'name' => 'price',
                'type' => 'number',
                'placeholder' => 'Kaina'
            ]);
            $form->input([
                'name' => 'year',
                'type' => 'number',
                'min' => '1950',
                'max' => '2022',
                'step' => '1',
                'placeholder' => 'Metai'
            ]);
            $types = Type::getTypes();
            $options = [];
            foreach ($types as $type) {
                $id = $type->getId();
                $options[$id] = $type->getType();
            }

            $form->select(['name' => 'type_id', 'options' => $options]);

            $form->input([
                'name' => 'create',
                'type' => 'submit',
                'value' => 'Sukurti'
            ]);

        }
//        return ['page_content' => $form->getForm()];
        $this->data['form'] = $form->getForm();
        $this->render('catalog/add');
    }

    public function create()
    {
        $ad = new Ad();
        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['desc']);
        $ad->setManufacturerId($_POST['manufacturer_id']);
        $ad->setModelId($_POST['model_id']);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId($_POST['type_id']);
        $ad->setUserId($_SESSION['user_id']);
        $ad->save();
        Url::redirect('catalog/all');
    }

    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('');
        }
        $ad = new Ad();
        $ad->load($id);

//        if ($_SESSION['user_id'] != $ad->getUserId()) {
//            Url::redirect('');
//        }

        $form = new FormHelper('catalog/update', 'POST');
        $form->input([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Pavadinimas',
            'value' => $ad->getTitle()
        ]);

        $form->input([
            'name' => 'id',
            'type' => 'hiden',
            'value' => $ad->getId()

        ]);

        $form->textArea('description', $ad->getDescription());
        $form->input([
            'name' => 'price',
            'type' => 'text',
            'placeholder' => 'Kaina',
            'value' => $ad->getPrice()
        ]);
        $form->input([
            'name' => 'year',
            'type' => 'text',
            'placeholder' => 'Metai',
            'value' => $ad->getYear()
        ]);

        $form->input([
            'type' => 'submit',
            'value' => 'sukurti',
            'name' => 'create'
        ]);
        $this->data['form'] = $form->getForm();
        $this->render('catalog/edit');
    }

    public function update()
    {
        $adId = $_POST['id'];
        $ad = new Ad();
        $ad->load($adId);
        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setManufacturerId(1);
        $ad->setModelId(1);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId(1);
        $ad->save();
    }

    public function all()
    {
        $this->data['ads'] = Ad::getAllAds();
        $this->render('catalog/all');
    }
}
