<?php
//$email = $_POST['email'];
//function isEmailValid($email)
//{
//    if (strpos($email, '@')) {
//        return true;
//    } else {
//        return false;
//    }
//}
//if (isEmailValid($email)){
//    echo 'Viskas gerai';
//}else{
//    echo 'Neteisingas';
//}

//$x = $_POST['number1'];
//$y = $_POST['number2'];
//
//switch ($_POST['operation']){
//    case '+':
//        echo $x + $y;
//        break;
//    case '-':
//        echo $x - $y;
//        break;
//    case '*':
//        echo $x * $y;
//        break;
//    case '/':
//        echo $x / $y;
//        break;
//}
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password1 = $_POST['password'];
$password2 = $_POST['RepPassword'];

function isEmailValid($email)
{
    if (strpos($email, '@')) {
        return true;
    }
    return false;
}

if (isEmailValid($email)) {
    function getNickName($name, $surname)
    {
        return strtolower(substr($name, 0, 3) . substr($surname, 0, 3));
    }
} else {
    echo 'Email is not valid';
    return;
}
function isPasswordValid($password1, $password2)
{
    if ($password1 === $password2) {
        return true;
    }
    return false;
}

function clearEmail($email)
{
    $emailLowercases = strtolower($email);
    return trim($emailLowercases);
}

if (isPasswordValid($password1, $password2)) {
    echo 'Name:' . $name;
    echo '<br>';
    echo 'Surname:' . $surname;
    echo '<br>';
    echo 'Email:' . clearEmail($email);
    echo '<br>';
    echo 'Nickname:' . getNickName($name, $surname);
    echo '<br>';
    echo 'Registration successful';

} else {
    echo 'Password does not match';
    return;
}
