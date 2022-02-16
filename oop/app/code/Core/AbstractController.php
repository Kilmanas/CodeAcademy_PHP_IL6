<?php

namespace Core;

use Helper\Url;

class AbstractController
{
    protected $data;

    public function __construct()
    {
        $this->data = [];
    }

    public function render($template)
    {
        include_once PROJECT_ROOT_DIR . '/app/design/parts/header.php';
        include_once PROJECT_ROOT_DIR . '/app/design/' . $template . '.php';
        include_once PROJECT_ROOT_DIR . '/app/design/parts/footer.php';
    }

    public function url($path, $param = null)
    {
        return Url::link($path, $param);
    }

    protected function isUserLoged()
    {
        return isset($_SESSION['user_id']);
    }

}
