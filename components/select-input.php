<?php

class SelectInput
{

    public $select;
    public $defaultval;
    public $data;
    public $return;

    public function get_select($defaultval, $select, $data = null)
    {

        $this->defaultval = $defaultval;
        $this->select = $select;



        $return = ' <div class="input-select"><div class="selected-label">';
        $return .= $this->defaultval;
        $return .= '</div><div class="select-options hide-options">';

        foreach ($this->select as $key => $value) {

            $return .= '<div class="select-option"><input type="radio" name="' . $key . '" id="' . $key . '" class="hidden-option"><label class="select-option-label" for="' . $key . '">' . $value . '</label></div>';
        }

        if ($data) {

            $this->data = $data;

            $return .= '<div class="select-input-data"';

            foreach ($this->data as $data => $datavalue) {

                $return .= ' ' . $data . '="' . $datavalue . '"';
            }

            $return .= '></div>';
        }

        $return .= '</div></div>';

        return $return;
    }
}


function get_select_input($defaultval, $select, $data = null)
{
    $newinput = new SelectInput;
    return $newinput->get_select($defaultval, $select, $data);
}
