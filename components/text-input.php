<?php

class TextInput
{

    public $type;
    public $args;
    public $label;
    public $return;

    public function get_text($args)
    {


        $return = '<div class="input-container"><input type="' . $args["type"] . '" ';

        foreach ($this->args as $key => $value) {

            $return .= $key . '="' . $value . '" ';
        }

        $return .= '><div class="input-label">' . $args["label"] . '</div></div>';

        return $return;
    }
}

function get_text_input($args)
{
    $newinput = new TextInput;
    return $newinput->get_text($args);
}
