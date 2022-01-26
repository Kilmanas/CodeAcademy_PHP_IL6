<?php
namespace Controller;

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
}
