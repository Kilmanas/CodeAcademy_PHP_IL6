<?php

namespace Helper;

class Url
{
    public static function redirect($route){
        header('Location: '.BASE_URL.$route);
        exit;
    }
    public static function link($path, $param = null)
    {
        $link = BASE_URL.$path;
        if ($param !== null){
            $link .= '/'.$param;
        }
        return $link;
    }
    public static function slug($string)
    {
        $string = strtolower($string);
        $string=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $string;
    }
    public static function staticUrl($path, $param = null)
    {
        $url = BASE_URL_WO_INDEX.$path;
        if ($param !== null){
            $url .= '/'.$param;
        }
        return $url;
    }
}