<?php
for($y = 0; $y < 10; $y++){
    for($x = 0; $x < 10; $x++){
        if($y % 2 == 0){
            echo '#';
        }else{
            if ($x % 2 == 0){
                echo '#';
            }else{
                echo '.';
            }
        }
    }
    echo '<br>';
}