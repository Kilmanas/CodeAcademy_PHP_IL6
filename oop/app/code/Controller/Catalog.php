<?php
namespace Controller;

use Helper\FormHelper;
use Helper\Url;
use Model\Manufacturer;
use Model\Model;
use Model\User as UserModel;

class Catalog
{
    public function show($id = null)
    {
        if($id !== null){
            echo 'Catalog controller ID ' . $id;
        }
    }

    public function all()
    {
        for ($i = 0; $i < 10; $i++) {
            echo '<a href="http://localhost/pamokos/oop/index.php/catalog/show/' . $i . '">Read more</a>';
            echo '<br>';
        }
    }
    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        } else {
            $userId = $_SESSION['user_id'];
            $user = new UserModel();
            $user->load($userId);
            $form = new FormHelper('user/update', 'POST');
            $form->input([
                'name' => 'title',
                'type' => 'text',
                'placeholder' => 'Pavadinimas'
            ]);
            $form->textArea('desc','Aprašymas');

            $manufacturers = Manufacturer::getManufacturers();
            $options = [];
            foreach ($manufacturers as $manufacturer) {
                $id = $manufacturer->getId();
                $options[$id] = $manufacturer->getManufacturer();
            }
            $form->select(['name' => 'manufacturer_id', 'options' => $options]);

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


            return ['page_content' => $form->getForm()];
        }
    }
}
