<?php

class Button
{
    public function render($text, $link)
    {
        return '<a href="' . $link . '" class="button">' . $text . '</a>';
    }
}

function get_button($text, $link)
{
    $button = new Button();
    return $button->render($text, $link);
}
