<?php

function clearEmail($email)
{
    $emailLowercases = strtolower($email);
    return trim($emailLowercases);
}
function isPasswordValid($password1, $password2)
{
    if ($password1 === $password2) {
        return true;
    }
    return false;
}
function hashPassword($password)
{
    return md5(md5($password) . 'druska');
}