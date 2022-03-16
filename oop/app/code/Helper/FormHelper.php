<?php
declare(strict_types=1);

namespace Helper;

use http\Encoding\Stream;
use mysql_xdevapi\SqlStatementResult;

class FormHelper
{

    private string $form;

    public function __construct(string $action, string $method)
    {
        $this->form = '<form action="' . BASE_URL . $action . '" method="' . $method . '">';
    }

    public function input(array $data) :void
    {
        $this->form .= '<input ';
        foreach ($data as $attribute => $value) {
            $this->form .= $attribute . '="' . $value . '" ';
        }
        $this->form .= ' ><br>';
    }

    public function textArea(string $name, string $placeholder = '') :void
    {
        $this->form .= '<textarea name="' . $name . '">' . $placeholder . '</textarea>';
        $this->form .= ' <br>';

    }


    public function select(array $data) :void
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

    public function selectModel(array $data) :void
    {
        $this->form .= '<select name="model_id">';
        foreach ($data as $key => $option) {
           $this->form .= '<option value="' . $key . '" data-manufacturer-id="' . $option['manufacturerId'] . '">' . $option['model'] . '</option>';
        }
        $this->form .= '</select>';
        $this->form .= ' <br>';

    }

    public function getForm() :string
    {
        $this->form .= '</form>';
        return $this->form;
    }
}