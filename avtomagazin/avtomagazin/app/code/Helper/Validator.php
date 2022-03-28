<?php

namespace Helper;

Class Validator
{
    public static function checkPassword($pass, $hash): bool
    {
        return password_verify($pass, $hash);
    }

    public static function checkEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}