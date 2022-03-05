<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\FormHelper;
use Helper\Url;
use Model\Messages as MessagesModel;


class Messages extends AbstractController implements ControllerInterface
{

    public function index()
    {

        $this->data['messages'] = MessagesModel::getAllMessages($_SESSION['user_id']);


        foreach ($this->data['messages'] as $message){
            $open = new MessagesModel($message->getId());
            $open->setOpened(1);
            $open->save();
        }

        $this->render('messages/inbox');

    }

    public function create($userTo)
    {
        if (!$this->isUserLoged()) {
            Url::redirect('user/login');
        } else {
            $form = new FormHelper('messages/send', 'POST');

            $form->input([
                'name' => 'user_from',
                'value' => $_SESSION['user_id'],
                'type' => 'hidden'
            ]);
            $form->input([
                'name' => 'user_to',
                'value' => $userTo,
                'type' => 'hidden'
            ]);
            $form->textArea('message', 'žinutė');
            $form->input([
                'name' => 'submit',
                'value' => 'Siųsti',
                'type' => 'submit'
            ]);

            $this->data['message'] = $form->getForm();
            $this->render('messages/create');
        }
    }

    public function send()
    {
        $message = new MessagesModel();
        $message->setUserFrom($_POST['user_from']);
        $message->setUserTo($_POST['user_to']);
        $message->setMessage($_POST['message']);
        $message->setOpened(0);
        $message->save();

        Url::redirect('');
    }
}