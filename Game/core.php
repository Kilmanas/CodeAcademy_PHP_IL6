<?php

const TOOL_ROCK = 'rock';
const TOOL_PAPER = 'paper';
const TOOL_SCISSORS = 'scissors';

$toolsArray = [
    0 => TOOL_ROCK,
    1 => TOOL_PAPER,
    2 => TOOL_SCISSORS
];

if (isset($_POST['play'])) {
    $playerChoice = $_POST['tool'];
    $pcChoice = rand(0, 2);
    $pcChoice = $toolsArray[$pcChoice];
    echo '<table>';
    echo '<tr><td ><img width="200" src="img/' . $playerChoice . '.png"></td><td>VS</td><td ><img width="200" src="img/' . $pcChoice . '.png"></td></tr>';
    echo '</table>';
    // 1 player choice, 2 player coice, result
    $result = null;

    if ($playerChoice == $pcChoice) {
        echo 'Lygiosios';
        $result = 'draw';
    } elseif ($playerChoice == TOOL_ROCK && $pcChoice == TOOL_SCISSORS) {
        echo 'Laimejote';
        $result = 'win';
    } elseif ($playerChoice == TOOL_PAPER && $pcChoice == TOOL_ROCK) {
        echo 'Laimejote';
        $result = 'win';
    } elseif ($playerChoice == TOOL_SCISSORS && $pcChoice = TOOL_PAPER) {
        echo 'Laimejote';
        $result = 'win';
    } else {
        $result = 'lost';
        echo 'Pralaimejote';
    }

    $file = fopen('history.csv', 'a');
    fputcsv($file,[$playerChoice, $pcChoice, $result]);
    fclose($file);
}

function getResults(){
    $file = fopen('history.csv', 'r');
    $data = [];
    while (!feof($file)){
        $data[] = fgetcsv($file);
    }

    return $data;
}

