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
use Model\Comments;

class Catalog extends AbstractController
{
    public function index()
    {
        $this->data['count'] = Ad::count('ad');
        $page = 1;
        if(isset($_GET['p'])){
            $page = (int)$_GET['p'] - 1;
        }
        $perPage = 5;
        $this->data['ads'] = Ad::getAllActiveAds($page, $perPage);
        $this->render('catalog/all');


    }
    public function show($slug)
    {
        $ad = new Ad();
        $this->data['ad'] = $ad->loadBySlug($slug);
        $this->data['title'] = $ad->getTitle();
        $this->data['meta_desc'] = $ad->getDescription();
        $comments = new Comments();
        $this->data['comments'] = $comments->getAdComments($ad->getId());

//        $newViews = (int)$ad->getCount() + 1;
//        $ad->setCount($newViews);
//        $ad->save();
        $commentForm = new FormHelper("catalog/comment", "post");
        $commentForm->textArea("comment", "Komentaras");
        $commentForm->input(["type"=>"hidden", "name"=>"ad_id", "value"=>$ad->getId()]);
        $commentForm->input(["type"=>"submit", "name"=>"submit", "value"=>"Rašyti"]);

        $this->data['comment_form'] = $commentForm->getForm();

        if($this->data['ad']) {
            $this->manufacturer = $ad->getManufacturer();
            $this->model = $ad->getModel();
            $this->type = $ad->getType();
            $this->render('catalog/show');
        } else {
            $error = new Error();
            $error->error404();
        }
    }


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
                'name' => 'price',
                'type' => 'number',
                'step' => '0.01',
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
                'name' => 'image',
                'type' => 'url',
                'placeholder' => 'https://nuotraukosnuoroda.lt',
                'pattern' => 'https://.*'
            ]);
            $form->input([
                'name' => 'vin',
                'type' => 'text',
                'placeholder' => 'VIN',
                'maxlength' => '17'
            ]);
//            $form->input([
//                'name' => 'active',
//                'type' => 'checkbox',
//                'label' => 'Aktyvus'
//            ]);
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
        $slug = Url::slug($_POST['title']);
        while(!Ad::valueUniq('slug',$slug,'ad')){
            $slug = $slug.rand(0,100);
        }
        $vin= strtoupper($_POST['vin']);
        $ad = new Ad();
        $ad->setTitle($_POST['title']);
        $ad->setSlug($slug);
        $ad->setDescription($_POST['desc']);
        $ad->setManufacturerId($_POST['manufacturer_id']);
        $ad->setModelId($_POST['model_id']);
        $ad->setVin($vin);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId($_POST['type_id']);
        $ad->setPictureUrl($_POST['image']);
        $ad->setUserId($_SESSION['user_id']);
        isset($_POST['active']);
        $ad->setActive(1);
        $ad->save();
        Url::redirect('catalog');
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
        $form->input([
            'type' => 'submit',
            'value' => 'Redaguoti',
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
        $ad->setVin(($_POST['vin']));
        $ad->setManufacturerId($_POST['manufacturer_id']);
        $ad->setModelId($_POST['model_id']);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setTypeId($_POST['type_id']);
        $ad->setPictureUrl($_POST['image']);
        isset($_POST['active']);
        $ad->setActive(1);
        $ad->save();
        Url::redirect('catalog');
    }
    public function pages()
    {
       $form = new FormHelper('/?p=2', 'GET');
       $form->input([
           'name' => 'page',
           'type' => 'submit',
           'value' => 'Kitas puslapis'
       ]);
        $this->page['button'] = $form->getForm();
        $this->render('catalog/all');

    }

    public function comment()
    {
        if(!$this->isUserLoged()) {
            Url::redirect("user/login");
        }

        $ad = new Ad();
        $ad->load($_POST["ad_id"]);

        if(!isset($_POST["comment"]) || strlen($_POST["comment"]) <= 5) {
            Url::redirect("catalog/show/" . $ad->getSlug());
        }

        $comment = new Comments();
        $comment->setUserId($_SESSION["user_id"]);
        $comment->setAdId($_POST["ad_id"]);
        $comment->setComment($_POST["comment"]);

        $comment->save();

        Url::redirect("catalog/show/" . $ad->getSlug());
    }

}
