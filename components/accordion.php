<?php

class AccordionMenu
{

    public $accordion;
    public $return;

    public function accordion()
    {

        return '<div class="accordion">';
    }

    public function accordion_title($accordion)
    {

        $this->accordion = $accordion;

        $return = '';

        foreach ($this->accordion as $key => $value) {

            $return .= '<div class="accordion-title">' . $key . '</div>';
            $return .= '<span class="accordion-panel panel-hide">' . $value . '</span>';
        }

        return $return;
    }

    public function end_of_div()
    {

        return '</div>';
    }

    public function get_accordion($accordion)
    {

        $return = $this->accordion();
        $return .= $this->accordion_title($accordion);
        $return .= $this->end_of_div();

        return $return;
    }
}

function get_accordion($args)
{
    $newinput = new AccordionMenu;
    return $newinput->get_accordion($args);
}
