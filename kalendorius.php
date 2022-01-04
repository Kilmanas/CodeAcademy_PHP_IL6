<?php
for($years = 2015; $years < 2022; $years++) {
    for ($months = 1; $months <= 12; $months++) {

        if ($months == 2) {
            if($years % 4 == 0) {
                for ($day = 1; $day <= 29; $day++) {
                    echo $years . ' ' . $months . ' ' . $day;
                    echo '<br>';
                }
            }else{
                for ($day = 1; $day <= 28; $day++) {
                    echo $years . ' ' . $months . ' ' . $day;
                    echo '<br>';
                }
            }
        } elseif ($months % 2 == 0) {
            for ($day = 1; $day <= 30; $day++) {
                echo $years . ' ' . $months . ' ' . $day;
                echo '<br>';
            }
        } else {
            for ($day = 1; $day <= 31; $day++) {
                echo $years . ' ' . $months . ' ' . $day;
                echo '<br>';
            }
        }
    }
}