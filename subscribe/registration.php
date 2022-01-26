<?php

$email = $_POST['email'];

function isEmailValid($email)
{
    return strpos($email, '@') !== false;
}
function clearEmail($email)
{
    return trim(strtolower($email));
}

function readFromCsv($fileName)
{
    $data = [];
    $file = fopen($fileName, 'r');
    while (!feof($file)) {
        $line = fgetcsv($file);
        if (!empty($line)) {
            $data[] = $line;
        }
    }
    fclose($file);
    return $data;
}
    function isEmailUnique($email)
    {
        $users = readFromCsv('users.csv');
        foreach ($users as $user) {
            if ($user[0] === $email) {
                return false;
            }
        }
        return true;
    }

    $email = clearEmail($email);

    if (isEmailValid($email) && isEmailUnique($email)) {
        $file = fopen('users.csv', 'a');
        fputcsv($file, [$email]);
        fclose($file);
        echo 'Prenumerata sekminga';
    } else {
        echo 'Neteisinga informacija';
    }
