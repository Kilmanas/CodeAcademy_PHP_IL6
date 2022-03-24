<?php

namespace Service\PriceChangeInformer;

use Helper\DBHelper;
use Model\Favorites;
use Model\Messages as MessagesModel;

class Messanger
{
    public function setMessages($adId)
    {
        $users = Favorites::getUsersByAd($adId);
        foreach ($users as $user){
            $db = new DBHelper();
            $data = [
                'user_id' => $user,
                'ad_id'=> $adId
            ];
            $db->insert('price_informer_queue', $data)->exec();
        }

    }
}