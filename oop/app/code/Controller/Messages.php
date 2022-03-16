<?php

declare(strict_types=1);

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\FormHelper;
use Helper\Url;
use Model\Messages as MessagesModel;


class Messages extends AbstractController implements ControllerInterface
{
    public function __construct()
    {
        if(!$this->isUserLoged()){
            Url::redirect('user/login');
        }
    }

    public function index(): void
    {

        $messages = MessagesModel::getUserMessages();
        $chats = [];

        foreach ($messages as $message){
            if($message->getUserFrom() > $message->getUserTo()){
                $key = $message->getUserTo().'-'.$message->getUserFrom();
            }else{
                $key = $message->getUserFrom().'-'.$message->getUserTo();
            }
            $chatFriendId = $message->getUserFrom() == $_SESSION['user_id'] ? $message->getUserTo() : $message->getUserFrom();
            $chatFriend = new \Model\User();
            $chatFriend->load($chatFriendId);
            $chats[$key]['message'] = $message;
            $chats[$key]['chat_friend'] = $chatFriend;

        }
        usort($chats, function ($item1, $item2) {
            return $item2['message']->getId() <=> $item1['message']->getId();
        });
        $this->data['chat'] = $chats;
        $this->render('messages/inbox');

    }

    public function create(int $userTo): void
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

            $this->data['chat_form'] = $form->getForm();
            $this->render('messages/chat');
        }
    }

    public function send(): void
    {
        $message = new MessagesModel();
        $message->setUserFrom((int)$_SESSION['user_id']);
        $message->setUserTo((int)$_POST['user_to']);
        $message->setMessage((string)$_POST['message']);
        $message->setOpened(false);
        $message->save();

        Url::redirect('messages/chat/' . $_POST['user_to']);
    }
    public function chat($chatFriendId)
    {
        $this->data['messages'] = MessagesModel::getMessagesWithFriend($chatFriendId);
        MessagesModel::setSeen($chatFriendId, $_SESSION['user_id']);
        $this->data['user_to'] = $chatFriendId;
        $this->render('messages/chat');
    }



}