<?php

namespace Service\GetNewsFromApi;

use Model\News;

class WebitNews
{

    public function exec()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://webit-news-search.p.rapidapi.com/trending?language=en",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: webit-news-search.p.rapidapi.com",
                "X-RapidAPI-Key: " . WEBIT_API_KEY
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response);
            $newsFromWebit = $response->data->results;
            foreach ($newsFromWebit as $newFromWebit){
                if(!empty($newFromWebit->title)) {
                    $translate = new Translate();
                    $title = $translate->execute($newFromWebit->title);
                    $content = $translate->execute($newFromWebit->description);
                    $new = new News();
                    $new->setTitle($title);
                    $new->setSlug(str_replace(' ', '-', $newFromWebit->title));
                    if (isset($newFromWebit->description)) {
                        $new->setContent($content);
                    } else {
                        $new->setContent('Cia buvo tik skambi antraste ;)');
                    }
                    $new->setCreatedAt($newFromWebit->date);
                    $new->setImage($newFromWebit->image);
                    $new->setViews(0);
                    $new->setActive(1);
                    $new->setAuthorId(1);
                    $new->save();
                }
            }
        }
    }
}