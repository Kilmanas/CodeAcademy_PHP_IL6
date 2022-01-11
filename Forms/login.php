<?php

include 'helper.php';

$email = $_POST['email'];
$password = $_POST['password'];

$email = clearEmail($email);
$password = hashPassword($password);

$users = readFromCsv('users.csv');


$login = false;
foreach ($users as $user) {


    if ($password === $user[PASWORD_FIELD_KEY] && $email === $user[EMAIL_FIELD_KEY]) {
        $login = true;
        break;
    }
}


if ($login) {
    echo 'prisijungete';
} else {
    echo 'wrong email';
}


if($login){
    echo 'prisijungete';
}else{
    echo 'wrong email';
}
