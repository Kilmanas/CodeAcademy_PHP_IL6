<?php

namespace Service\PriceChangeInformer;

use Core\AbstractController;
use Helper\DBHelper;
use Model\Ad;
use Model\Messages;
use Model\Messages as MessagesModel;
use Model\User;


class Cron extends AbstractController
{
    public function exec()
    {
        $db = new DBHelper();
        $data = $db->select()->from('price_informer_queue')->limit(100)->get();
        foreach ($data as $element){
            $user = new User();
            $user->load($element['user_id']);
            $ad = new Ad($element['ad_id']);
            $messageText = 'Sveiki'. ' '.$user->getName().', skelbime'. ' '. $ad->getTitle(). ' '."pasikeitė kaina. Peržiūrėkite skebimą <a href=".$this->url('catalog/show/').$ad->getSlug().">Čia</a>";
            $message = new MessagesModel();
            $message->setUserFrom((int)20);
            $message->setUserTo((int)$user->getId());
            $message->setMessage($messageText);
            $message->setOpened(false);
            $message->save();
            $db = new DBHelper();
            $db->delete()->from('price_informer_queue')->where('id', $element['id'])->exec();
        }
    }
}