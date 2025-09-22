<?php

function customtheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'customtheme_add_woocommerce_support');
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
add_filter('woocommerce_ship_to_different_address_checked', '__return_true');


// CUSTOM CSS & JS
function ebaskicim_custom_css()
{
    wp_enqueue_style('ebaskicim-styles', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), '1.0', 'all');
    wp_enqueue_style('ebaskicim-tailwind', get_stylesheet_directory_uri() . '/assets/css/tw-output.css', array(), '1.0', 'all');
    wp_enqueue_style('ebaskicim-main-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js', array(), false, true);
    wp_enqueue_script('ebaskicim-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'ebaskicim_custom_css', 20);

include get_template_directory() . '/components/button.php';
include get_template_directory() . '/includes/products.php';
include get_template_directory() . '/components/section.php';

class Tab_input
{

    public $tab;
    public $panel;
    public $return;

    public function tab_input_container()
    {

        return '<div class="tab-menu">';
    }

    public function tab_container()
    {

        return '<div class="tm-tabs">';
    }

    public function tab($tab)
    {

        $this->tab = $tab;

        $return = '';

        foreach ($this->tab as $key => $value) {

            $return .= '<div class="tm-tab">';
            $return .= '<input type="radio" class="tab-radio-hidden"';

            if ($value[1] && is_array($value[1])) {

                foreach ($value[1] as $inputkey => $inputval) {

                    $return .= ' ' . $inputkey . '="' . $inputval . '"';
                }
            }

            $return .= '>';
            $return .= '<label';

            if (is_array($value[1]) && $value[1]['id']) {

                $return .= ' for="' . $value[1]['id'] . '"';
            }

            $return .= '>' . $key . '</label>';
            $return .= '</div>';
        }

        return $return;
    }

    public function panel_container()
    {

        return '<div class="tm-tab-panels">';
    }

    public function panel($panel)
    {

        $this->panel = $panel;

        $return = '';

        foreach ($this->panel as $key => $value) {

            if (is_array($value)) {

                $return .= '<div class="tm-tab-panel">' . $value[0] . '</div>';
            } else {

                $return .= '<div class="tm-tab-panel">' . $value . '</div>';
            }
        }

        return $return;
    }

    public function end_of_div()
    {

        return '</div>';
    }

    public function get_tab($tab)
    {

        $return = $this->tab_input_container();
        $return .= $this->tab_container();
        $return .= $this->tab($tab);
        $return .= $this->end_of_div();
        $return .= $this->panel_container();
        $return .= $this->panel($tab);
        $return .= $this->end_of_div();
        $return .= $this->end_of_div();

        return $return;
    }
}

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

class TextInput
{

    public $type;
    public $args;
    public $label;
    public $return;

    public function get_text($type, $args, $label)
    {

        $this->type = $type;
        $this->args = $args;

        $return = '<div class="input-container"><input type="' . $type . '" ';

        foreach ($this->args as $key => $value) {

            $return .= $key . '="' . $value . '" ';
        }

        $return .= '><div class="input-label">' . $label . '</div></div>';

        return $return;
    }
}

function get_input($input, $args, $args2 = null, $args3 = null)
{

    if ($args && $input) {

        if ($input == 'quantity') {

            $newinput = new QuantityInput;

            return $newinput->get_quantity($args);
        }

        if ($input == 'accordion') {

            $newinput = new AccordionMenu;

            return $newinput->get_accordion($args);
        }

        if ($input == 'tab') {

            $newinput = new Tab_input;

            return $newinput->get_tab($args);
        }

        if ($input == 'select') {

            $newinput = new SelectInput;

            return $newinput->get_select($args2, $args, $args3);
        }

        if ($input == 'text' || $input == 'password' || $input == 'email') {

            $newinput = new TextInput;

            return $newinput->get_text($input, $args, $args2);
        }
    } else {

        return false;
    }
}

function get_the_input($input, $args, $args2 = null, $args3 = null)
{

    echo get_input($input, $args, $args2, $args3);
}
