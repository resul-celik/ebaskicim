<?php

class Button
{
    public function render($args): string
    {

        $args["text"] = $args["text"] ?? '';
        $args["url"] = $args["url"] ?? '';
        $args["classes"] = $args["classes"] ?? '';
        $args["hierarchy"] = $args["hierarchy"] ?? 'primary';
        $args["size"] = $args["size"] ?? 'medium';
        $args["leadingIcon"] = $args["leadingIcon"] ?? '';
        $args["trailingIcon"] = $args["trailingIcon"] ?? '';
        $args["icon"] = $args["icon"] ?? '';
        $args["type"] = $args["type"] ?? '';
        $args["value"] = $args["value"] ?? '';
        $args["name"] = $args["name"] ?? '';
        $args["target"] = $args["target"] ?? '';
        $args["theme"] = $args["theme"] ?? 'light';
        $args["destructive"] = $args["destructive"] ?? false;

        if ($args["url"]) {
            $button = '<a href="' .  $args["url"] . '" class="button';
            if ($args["classes"]) {
                $button .= ' ' . $args["classes"];
            }
        } else {
            $button = '<button class="button';
            if ($args["classes"]) {
                $button .= ' ' . $args["classes"];
            }
        }

        if ($args["theme"] == 'dark') {
            if ($args["hierarchy"] == 'secondary') {
                $button .= $args["destructive"] ? ' secondary-button-dark-destructive' : ' secondary-button-dark';
            } else if ($args["hierarchy"] == 'tertiary') {
                $button .= $args["destructive"] ? ' tertiary-button-dark-destructive' : ' tertiary-button-dark';
            } else if ($args["hierarchy"] == 'link') {
                $button .= ' link-button-dark';
            } else {
                $button .= $args["destructive"] ? ' primary-button-dark-destructive' : ' primary-button-dark';
            }
        } else {
            if ($args["hierarchy"] == 'secondary') {
                $button .= $args["destructive"] ? ' secondary-button-destructive' : ' secondary-button';
            } else if ($args["hierarchy"] == 'tertiary') {
                $button .= $args["destructive"] ? ' tertiary-button-destructive' : ' tertiary-button';
            } else if ($args["hierarchy"] == 'link') {
                $button .= $args["destructive"] ? ' link-button-destructive' : ' link-button';
            } else {
                $button .= $args["destructive"] ? ' primary-button-destructive' : ' primary-button';
            }
        }

        if ($args["hierarchy"] !== 'link') {
            if ($args["size"] == 'large') {
                $button .= ' large-button';
            } else {
                $button .= ' medium-button';
            }
        }

        if ($args["leadingIcon"]) {
            $button .= ' leading-icon';
        }

        if ($args["trailingIcon"]) {
            $button .= ' trailing-icon';
        }

        if ($args["icon"]) {
            $button .= ' icon-only';
        }

        if ($args["type"]) {
            $button .= '" type="' . $args["type"];
        }

        if ($args["value"]) {
            $button .= '" value="' . $args["value"];
        }

        if ($args["name"]) {
            $button .= '" name="' . $args["name"];
        }

        if ($args["target"]) {
            $button .= '" target="' . $args["target"];
        }

        $button .= '">';

        if ($args["icon"]) {
            $button .= '<i class="icon icon-' . $args["icon"] . '"></i>';
        } else {

            if ($args["leadingIcon"]) {
                $button .= '<i class="icon icon-' . $args["leadingIcon"] . '"></i>';
            }

            $button .= $args["text"];

            if ($args["trailingIcon"]) {
                $button .= '<i class="icon icon-' . $args["trailingIcon"] . '"></i>';
            }
        }

        if ($args["url"]) {
            $button .= '</a>';
        } else {
            $button .= '</button>';
        }

        return $button;
    }
}

function get_button($args)
{
    $button = new Button();
    return $button->render($args);
}
