<?php

namespace Service\GetNewsFromApi;

class Translate
{
    public function execute($string)
    {


        $curl = curl_init();
        $string = urlencode($string);

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://just-translated.p.rapidapi.com/?lang=lt&text=".$string ,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: just-translated.p.rapidapi.com",
                "X-RapidAPI-Key: e4e3a52b0emsh4d5d32ac0d22ce9p1c1a42jsn980327d1ed5c"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response);
            return $response->text[0];
        }
    }
}