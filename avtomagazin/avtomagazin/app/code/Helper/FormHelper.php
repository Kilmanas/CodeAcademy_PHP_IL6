<?php

namespace Helper;

class FormHelper
{

    private $form;

    public function __construct($action, $method)
    {
        $this->form = '<form action="' . BASE_URL . $action . '" method="' . $method . '">';
    }

    public function input($data)
    {
        $this->form .= '<input ';
        foreach ($data as $attribute => $value) {
            $this->form .= $attribute . '="' . $value . '" ';
        }
        $this->form .= ' ><br>';
    }

    public function textArea($name, $placeholder = '')
    {
        $this->form .= '<textarea name="' . $name . '">' . $placeholder . '</textarea>';
        $this->form .= ' <br>';

    }


    public function select($data)
    {
        $this->form .= '<select name="' . $data['name'] . '">';
        foreach ($data['options'] as $key => $option) {
            $this->form .= '<option';
            if(isset($data['selected'])){
                if($data['selected'] == $key){
                    $this->form .= ' selected ';
                }
            }
            $this->form .= ' value="' . $key . '">' . $option . '</option>';
        }
        $this->form .= '</select>';
        $this->form .= ' <br>';
    }

    public function selectModel($data)
    {
        $this->form .= '<select name="model_id">';
        foreach ($data as $key => $option) {
           $this->form .= '<option value="' . $key . '" data-manufacturer-id="' . $option['manufacturerId'] . '">' . $option['model'] . '</option>';
        }
        $this->form .= '</select>';
        $this->form .= ' <br>';

    }
    public function getForm()
    {
        $this->form .= '</form>';
        return $this->form;
    }
}