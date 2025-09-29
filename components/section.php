<?php

class Section
{

    public function sectionHead($title, $url)
    {

        $buttonArgs = array(
            "url" => $url,
            "text" => "Tümünü Gör",
            "trailingIcon" => "arrow-right",
            //"hierarchy" => "primary",  // Default is primary
            //"theme" => "light", // Default is light
            //"size" => "medium" // Default is medium
        );

        $return = '<div class="w-full flex flex-row items-center justify-between"><h2 class="section-title">' . $title . '</h2>';
        $url === null ? $return .= "" : $return .= get_button($buttonArgs);
        $return .= '</div>';
        return $return;
    }

    public function getSection($title, $url, $order, $contentFunction, $category): string
    {
        $sectionHead = $this->sectionHead($title, $url);
        $order = $order ? $order : 1;
        $content = '';
        $content .= '<section class="w-full max-w-[1920px] flex flex-col px-20 pb-100 gap-30" style="order: ' . $order . ';">' . $sectionHead . $contentFunction($category) . '</section>';
        return $content;
    }
}

function get_section($args, callable $contentCallback)
{
    $defaults = [
        "title" => "",
        "url" => "",
        "order" => 1,
        "function_args" => []
    ];


    $args = array_merge($defaults, $args);

    echo '<section class="w-full max-w-[1920px] flex flex-col px-20 pb-100 gap-30" style="order: ' . $args["order"] . ';">';
    echo '<div class="w-full flex flex-row items-center justify-between"><h2 class="section-title">' . esc_html($args['title']) . '</h2>';
    if ($contentCallback) {
        call_user_func($contentCallback);
    }
    echo '</section>';
}
