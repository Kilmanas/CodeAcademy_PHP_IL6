<?php
declare(strict_types=1);

namespace Core;

use Helper\Url;
use Model\Messages;
use Model\User;

class AbstractController
{
    protected $data;

    public function __construct()
    {
        $this->data = [];
        $this->data['title'] = 'vagiu.lt';
        $this->data['meta_desc'] = '';
    }

    public function render(string $template): void
    {
        include_once PROJECT_ROOT_DIR . '/app/design/parts/header.php';
        include_once PROJECT_ROOT_DIR . '/app/design/' . $template . '.php';
        include_once PROJECT_ROOT_DIR . '/app/design/parts/footer.php';
    }

    public function url(string $path, ?string $param = null): string
    {
        return Url::link($path, $param);
    }

    public function staticUrl(string $path, ?string $param = null): string
    {
        return Url::staticUrl($path, $param);
    }

    public function newMessageCount(): int
    {
        return Messages::countNewMessages($_SESSION['user_id']);
    }

    protected function renderAdmin(string $template): void
    {
        include_once PROJECT_ROOT_DIR . '/app/design/admin/parts/header.php';
        include_once PROJECT_ROOT_DIR . '/app/design/admin/' . $template . '.php';
        include_once PROJECT_ROOT_DIR . '/app/design/admin/parts/footer.php';
    }

    protected function isUserAdmin(): bool
    {
        if ($this->isUserLoged()) {
            $user = new User();
            $user->load($_SESSION['user_id']);
            if ($user->getRoleId() == 1) {
                return true;
            }
        }

        return false;
    }

    protected function isUserLoged(): bool
    {
        return isset($_SESSION['user_id']);
    }

}
