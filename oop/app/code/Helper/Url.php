<?php

declare(strict_types=1);

namespace Helper;

class Url
{
    public static function redirect(string $route) :void
    {
        header('Location: '.BASE_URL.$route);
        exit;
    }
    public static function link(string $path, ?string $param = null) :string
    {
        $link = BASE_URL.$path;
        if ($param !== null){
            $link .= '/'.$param;
        }
        return $link;
    }
    public static function slug(string $string) :string
    {
        $string = strtolower($string);
        $string=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $string;
    }
    public static function staticUrl(string $path, ?string $param = null) :string
    {
        $url = BASE_URL_WO_INDEX.$path;
        if ($param !== null){
            $url .= '/'.$param;
        }
        return $url;
    }
}