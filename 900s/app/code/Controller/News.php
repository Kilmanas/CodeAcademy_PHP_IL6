<?php

namespace Controller;

use Core\ControllerAbstract;

class News extends ControllerAbstract
{
    public function show(string $slug)
    {
        $new = new \Model\News();
        $new->loadBySlug($slug);
        echo $this->twig->render('news_show.html.twig', ['new' => $new]);
    }

    public function showAll()
    {
        $news = new \Model\News();
        $articles = $news->loadAll();
        $this->twig->display('news_showall.html.twig', ['articles' => $articles]);
    }
}