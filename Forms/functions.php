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

$x = $_POST['number1'];
$y = $_POST['number2'];

switch ($_POST['veiksmas']){
    case '+':
        echo $x + $y;
        break;
    case '-':
        echo $x - $y;
        break;
    case '*':
        echo $x * $y;
        break;
    case '/':
        echo $x / $y;
        break;
}