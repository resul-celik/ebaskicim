<?php

function get_section($args, callable $contentCallback)
{
    $defaults = [
        "title" => "",
        "url" => "",
        "order" => 1,
        "function_args" => []
    ];


    $args = array_merge($defaults, $args);
    $buttonArgs = array(
        "url" => $args["url"],
        "text" => "Tümünü Gör",
        "trailingIcon" => "arrow-right",
    );

    echo '<section class="w-full max-w-[1920px] flex flex-col px-20 pb-100 gap-30" style="order: ' . $args["order"] . ';">';
    echo '<div class="w-full flex flex-row items-center justify-between">';
    echo '<h2 class="section-title">' . esc_html($args['title']) . '</h2>';
    echo $args["url"] ? get_button($buttonArgs) : "";
    echo '</div>';
    if ($contentCallback) {
        call_user_func($contentCallback);
    }
    echo '</section>';
}
