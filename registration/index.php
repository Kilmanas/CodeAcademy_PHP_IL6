<?php
include 'formhelper.php';
$inputs = [
    [
            'type' => 'text',
            'name' => 'name',
            'placeholder' => 'Vardas'
    ],
    [
        'type' => 'text',
        'name' => 'last_name',
        'placeholder' => 'Pavarde'
    ],
    [
        'type' => 'password',
        'name' => 'password',
        'placeholder' => '********'
    ],
    [
        'type' => 'select',
        'name' => 'childrens_number',
        'options' => [0,1,2,3, '4+']
    ],
    [
        'type' => 'submit',
        'name' => 'register',
        'placeholder' => 'Registruotis'
    ],
    [
        'type' => 'textarea',
        'name' => 'text',
        'placeholder' => 'Tekstas'
    ]
];
echo '<form action="registration.php" method="post">';

foreach ($inputs as $input){
    if($input['type'] == 'input'){
       echo generateInput($input).'<br>';
}elseif($input['type'] == 'select'){
    echo generateSelect($input);
    }else{
        echo generateTextarea($input);
    }
}

echo '</form>';