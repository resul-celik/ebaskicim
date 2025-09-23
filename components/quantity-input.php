<?php

class QuantityInput
{

    public $args;
    public $return;

    public function get_quantity($args)
    {

        $this->args = $args;

        $return = '<div class="quantity-input quantity"><div class="decrease-quantity"><span>-</span></div><input type="number" class="quantity';

        if (isset($this->args['class'])) {

            $return .= ' ' . $this->args['class'];
        }

        $return .= '" ';

        foreach ($this->args as $key => $value) {

            if ($value) {

                $return .= $key . '="' . $value . '" ';
            }
        }

        $return .= ' pattern="[0-9]+"><div class="increase-quantity"><span>+</span></div></div>';

        return $return;
    }
}


function get_quantity_input($args)
{
    $newinput = new QuantityInput;
    return $newinput->get_quantity($args);
}
