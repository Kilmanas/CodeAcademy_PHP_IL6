<?php
include 'core.php';

$tools = [
    TOOL_ROCK => 'Akmuo',
    TOOL_PAPER => 'Popierius',
    TOOL_SCISSORS => 'Žirklės'
];

echo '<form action="http://localhost/pamokos/game/index.php" method="POST">';
echo '<select name="tool">';
foreach ($tools as $key => $tool){
    echo '<option value="'.$key.'">'.$tool.'</option>';
}
echo '</select>';
echo '<br>';

echo '<input type="submit" value="Play!" name="play">';
echo '</form>';