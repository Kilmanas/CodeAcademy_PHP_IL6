<?php
include 'helper.php';
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password1'];
$password2 = $_POST['password2'];
$email = clearEmail($email);
if (
    isPasswordValid($password, $password2) &&
    isEmailValid($email) &&
    isValueUniq($email, EMAIL_FIELD_KEY) &&
    isset($_POST['agree_terms'])
) {

    $nickName = generateNickName($firstName, $lastName);
    while (!isValueUniq($nickName, NICKNAME_FIELD_KEY)) {
        $nickName = $nickName . rand(0, 100);
    }
    $data = [];
    $password = hashPassword($password);

    $data[] = [$firstName, $lastName, $email, $nickName, $password];
    writeToCsv($data, 'users.csv');
    echo 'Registracija sekminga';
} else {
    echo 'Patikrinkite duomenis ir pabandykite dar karta.';
}

;
