<?php

include 'FormHelper.php';
$data1 = [
    'type' => 'text',
    'name' => 'name',
    'placeholder' => 'Vardas'
];
$data2 = [
    'type' => 'text',
    'name' => 'last_name',
    'placeholder' => 'Pavardė'
];
$data3 = [
    'type' => 'email',
    'name' => 'email',
    'placeholder' => 'Email'
];
$data4 = [
    'type' => 'password',
    'name' => 'password',
    'placeholder' => 'Password'
];

$formLogin = new FormHelper('login.php', 'POST');
$formRegister = new FormHelper('register.php', 'POST');
$formRegister->input($data1);
$formRegister->input($data2);
$formRegister->input($data3);
$formRegister->input($data4);
$formRegister->textArea('comment', 'Komentaras');

$formLogin->input($data3);
$formLogin->input($data4);

echo $formLogin->getForm();
echo '<br>';
echo $formRegister->getForm();