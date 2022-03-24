<?php
declare(strict_types=1);

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\FormHelper;
use Helper\Url;
use Model\Ad;
use Model\Favorites;
use Model\Manufacturer;
use Model\Messages as MessagesModel;
use Model\Model;
use Model\Ratings;
use Model\Type;
use Model\User as UserModel;
use Model\Comments;
use Service\PriceChangeInformer\Messanger;

class Catalog extends AbstractController implements ControllerInterface
{
    public function index(): void
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
    public function show(string $slug): void
    {
        $ad = new Ad();
        $this->data['ad'] = $ad->loadBySlug($slug);
        $this->data['title'] = $ad->getTitle();
        $this->data['meta_desc'] = $ad->getDescription();
        $comments = new Comments();
        $this->data['comments'] = $comments->getAdComments($ad->getId());
        $author = new UserModel();
        $this->data['author'] = $author->load($ad->getUserId());
        $commentForm = new FormHelper("catalog/comment", "post");
        $commentForm->textArea("comment", "Komentaras");
        $commentForm->input(["type"=>"hidden", "name"=>"ad_id", "value"=>$ad->getId()]);
        $commentForm->input(["type"=>"submit", "name"=>"submit", "value"=>"Rašyti"]);

        $this->data['comment_form'] = $commentForm->getForm();

        $this->data['rated'] = false;
        $rate = new Ratings();
        $isRateNull = $rate->loadByUserAndAd($_SESSION['user_id'], $ad->getId());
        if ($isRateNull !== null){
            $this->data['rated'] = true;
            $this->data['user_rate'] = $rate->getRank();
        }
        $this->data['favorites'] = false;
        $favorite = new Favorites();
        $isFavorite = $favorite->isAdFavoriteByUser($_SESSION['user_id'], $ad->getId());
        if ($isFavorite){
            $this->data['favorites'] = true;
        }

        $ratings = Ratings::getAdRating($ad->getId());
        $sum = 0;
        foreach ($ratings as $rate){
            $sum += $rate['rank'];

        }
        $this->data['ad_rating'] = 0;
        $this->data['rating_count'] = count($ratings);
        if($sum >0){
            $this->data['ad_rating'] = $sum / $this->data['rating_count'];
        }

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


    public function add(): void
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

    public function create(): void
    {
        $slug = Url::slug($_POST['title']);
        while(!Ad::valueUniq('slug',$slug,'ad')){
            $slug = $slug.rand(0,100);
        }
        $vin= strtoupper((string)$_POST['vin']);
        $ad = new Ad();
        $ad->setTitle((string)$_POST['title']);
        $ad->setSlug($slug);
        $ad->setDescription((string)$_POST['desc']);
        $ad->setManufacturerId((int)$_POST['manufacturer_id']);
        $ad->setModelId((int)$_POST['model_id']);
        $ad->setVin((string)$vin);
        $ad->setPrice((float)$_POST['price']);
        $ad->setYear((int)$_POST['year']);
        $ad->setTypeId((int)$_POST['type_id']);
        $ad->setPictureUrl((string)$_POST['image']);
        $ad->setUserId((int)$_SESSION['user_id']);
        isset($_POST['active']);
        $ad->setActive((bool)1);
        $ad->save();
        Url::redirect('catalog');
    }

    public function edit(int $id): void
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

    public function update(): void
    {

        $adId = $_POST['id'];
        $ad = new Ad();
        $ad->load((int)$adId);
        if ($ad->getPrice() !== $_POST['price']){
            $messanger = new Messanger();
            $messanger->setMessages($adId);

        }
        $ad->setTitle((string)$_POST['title']);
        $ad->setDescription((string)$_POST['description']);
        $ad->setVin(((string)$_POST['vin']));
        $ad->setManufacturerId((int)$_POST['manufacturer_id']);
        $ad->setModelId((int)$_POST['model_id']);
        $ad->setPrice((float)$_POST['price']);
        $ad->setYear((int)$_POST['year']);
        $ad->setTypeId((int)$_POST['type_id']);
        $ad->setPictureUrl((string)$_POST['image']);
        $ad->setActive((bool)1);
        $ad->save();

        Url::redirect('catalog');
    }
    public function pages(): void
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

    public function comment(): void
    {
        if(!$this->isUserLoged()) {
            Url::redirect("user/login");
        }

        $ad = new Ad();
        $ad->load((int)$_POST["ad_id"]);

        if(!isset($_POST["comment"]) || strlen($_POST["comment"]) <= 5) {
            Url::redirect("catalog/show/" . $ad->getSlug());
        }

        $comment = new Comments();
        $comment->setUserId((int)$_SESSION["user_id"]);
        $comment->setAdId((int)$_POST["ad_id"]);
        $comment->setComment((string)$_POST["comment"]);

        $comment->save();

        Url::redirect("catalog/show/" . $ad->getSlug());
    }
    public function rate()
    {
        $rate = new Ratings();
        $rate->loadByUserAndAd((int)$_SESSION['user_id'], (int)$_POST['ad_id']);
        $rate->setUserId((int)$_SESSION['user_id']);
        $rate->setAdId((int)$_POST['ad_id']);
        $rate->setRank((int)$_POST['rank']);
        $rate->save();
        Url::redirect('');
    }

    public function addToFavorites()
    {
        $favorite = new Favorites();
        $favorite->setUserId((int)$_SESSION['user_id']);
        $favorite->setAdId((int)$_POST['ad_id']);
        $favorite->setFavorite((bool)1);
        $favorite->save();
        $ad = new Ad();
        $ad->load((int)$_POST['ad_id']);
        Url::redirect('catalog/show/' . $ad->getSlug() );
    }

    public function removeFavorite()
    {
        $userId = $_SESSION['user_id'];
        $adId = $_POST['ad_id'];
        Favorites::removeFromFavorites((int) $userId, (int) $adId);
        $ad = new Ad();
        $ad->load((int)$_POST['ad_id']);
        Url::redirect('catalog/show/' . $ad->getSlug() );
    }
    public function favorites()
    {
        if(!$this->isUserLoged()) {
            Url::redirect("user/login");
        }
        $this->data['favorites'] = Favorites::loadUserFavorites($_SESSION['user_id']);
        $this->render('catalog/favorites');
    }
}
