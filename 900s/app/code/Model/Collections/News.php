<?php

namespace Model\Collections;

use Core\CollectionsAbstract;

class News  extends CollectionsAbstract
{
    const  TABLE = 'news';



    public function get() : ?array
    {
        $sql = $this->select;
        if ($rez = $this->db->getAll($sql)){
            $news = [];
            foreach ($rez as $article){
                $new = new \Model\News();
                $new->load((int)$article['id']);
                $news [] = $new;
            }
            return $news;
        } return null;
    }
    public function getArray()
    {
        return $this->db->getAll($this->select);
    }
}