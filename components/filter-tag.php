<?php

function ebs_get_filter_tag($args)
{
    $defaults = [
        "active" => false,
        "url" => "#",
        "text" => "filter_text"
    ];

    $args = array_merge($defaults, $args);
    $activeClass = $args["active"] ? 'bg-primary-400' : 'bg-gray-100 hover:bg-gray-200';

    return sprintf(
        '<a href="%s" class="flex flex-row items-center justify-center px-15 py-5 rounded-full paragraph-sm %s">%s</a>',
        $args["url"],
        $activeClass,
        $args["text"]

    );
}
