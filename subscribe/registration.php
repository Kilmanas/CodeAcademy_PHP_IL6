<?php
include 'helper.php';
$email = $_POST['email'];

$email= clearEmail($email);

if(isEmailValid($email)){
    $file = fopen('users.csv', 'a');
    fputcsv($file,[$email]);
    fclose($file);
    echo 'Prenumerata sekminga';
}else{
    echo 'Neteisinga informacija';
}
