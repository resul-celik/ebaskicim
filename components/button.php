<?php

function get_button($args)
{
    // Default values

    $defaults = [
        'text' => '',
        'url' => '',
        'classes' => '',
        'hierarchy' => 'primary',
        'size' => 'medium',
        'leadingIcon' => '',
        'trailingIcon' => '',
        'icon' => '',
        'type' => '',
        'value' => '',
        'name' => '',
        'target' => '_self',
        'theme' => 'light',
        'destructive' => false
    ];

    // Merge defaults and args (use default if it isn't set)
    $args = wp_parse_args($args, $defaults);

    // Set Classes
    $theme = $args["theme"] === "dark" ? "-dark" : "";
    $destructive = $args["destructive"] ? "-destructive" : "";
    $size  = $args["hierarchy"] !== "link" ? $args["size"] . "-button" : "";


    $classes = [
        "button",
        $args["hierarchy"] . "-button" . $theme . $destructive,
        $size,
        $args["leadingIcon"] ? "leading-icon" : "",
        $args["trailingIcon"] ? "trailing-icon" : "",
        $args["icon"] ? "icon-only" : ""
    ];

    // Set content of the button

    $content = '';

    if (!empty($args['icon'])) {
        $content = '<i class="icon icon-' . esc_attr($args['icon']) . '"></i>';
    } else {
        if (!empty($args['leadingIcon'])) {
            $content .= '<i class="icon icon-' . esc_attr($args['leadingIcon']) . '"></i>';
        }
        $content .= esc_html($args['text']);

        if (!empty($args['trailingIcon'])) {
            $content .= '<i class="icon icon-' . esc_attr($args['trailingIcon']) . '"></i>';
        }
    }

    // returns

    if (!empty($args['url'])) {
        return sprintf(
            '<a href="%s" class="%s" target="%s">%s</a>',
            esc_url($args['url']),
            esc_attr(implode(' ', $classes)),
            esc_attr($args["target"]),
            $content
        );
    } else {
        return sprintf(
            '<button type="%s" class="%s" value="%s" name="%s">%s</button>',
            esc_attr($args['type']),
            esc_attr(implode(' ', $classes)),
            esc_attr($args["value"]),
            esc_attr($args["name"]),
            $content
        );
    }
}
