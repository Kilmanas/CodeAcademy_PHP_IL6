<?php

function generateInput($data){
    $input = '';
    $input .= '<input ';
    foreach ($data as $key => $value){
        $input .= $key.'="'.$value.'" ';
    }
    $input .= '>';
    return $input;
}
function generateSelect($data){
    $select = '';
    $select .= '<select name="'.$data['name'].'">';
    foreach($data['options'] as $option){
    $select .= '<option value="'.$option.'">'.$option.'</option>';
    }
    $select .= '</select>';
    return $select;
}
function generateTextarea($data){
    $textarea = '';
    $textarea .= '<textarea name="'.$data['name'].'"></textarea>';
    return $textarea;

}
//<textarea id="story" name="story"
//          rows="5" cols="33">
//It was a dark and stormy night...
//</textarea>