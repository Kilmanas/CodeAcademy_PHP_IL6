<?php
include 'helper.php';
const TOOL_ROCK = 'rock';
const TOOL_PAPER = 'paper';
const TOOL_SCISSORS = 'scissors';

$toolsArray = [
    0 => TOOL_ROCK,
    1 => TOOL_PAPER,
    2 => TOOL_SCISSORS
];
if(isset($_POST['play'])){
    $playerChoice = $_POST['tool'];
    $pcChoice = rand(0,2);
    $pcChoice = $toolsArray[$pcChoice];
    echo '<table>';
    echo '<tr><td ><img width="200" src="img/' . $playerChoice . '.png"></td><td>VS</td><td ><img width="200" src="img/' . $pcChoice . '.png"></td></tr>';
    echo '</table>';
    if ($playerChoice == $pcChoice){
        $value = 0;
        echo 'Lygiosios';
    }elseif ($playerChoice == TOOL_ROCK && $pcChoice == TOOL_SCISSORS ){
        $value = 1;
        echo 'Laimėjote';
    }elseif ($playerChoice == TOOL_PAPER && $pcChoice == TOOL_ROCK){
        $value = 1;
        echo 'Laimėjote';
    }elseif ($playerChoice == TOOL_SCISSORS && $pcChoice == TOOL_PAPER){
        $value = 1;
        echo 'Laimėjote';
    }else{
        $value = 2;
        echo 'Pralaimėjote';
    }
    if ($value === 0){
        $winner = 'Lygiosios';
    }elseif($value === 1){
        $winner = 'Player';
    }else{
        $winner = 'Computer';
    }
    $data[] = [$playerChoice, $pcChoice, $winner];
    writeToCsv($data, 'history.csv');
}

