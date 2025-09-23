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
        return (
            '<div class="w-full flex flex-row items-center justify-between">
                <h2 class="section-title">' . $title . '</h2>
                ' . get_button($buttonArgs) . '
             </div>'
        );
    }

    public function getSection($title, $url, $order, $contentFunction): string
    {
        $sectionHead = $this->sectionHead($title, $url);
        $order = $order ? $order : 1;
        $content = '';
        $content .= '<section class="w-full max-w-[1920px] flex flex-col px-[20px] pb-[100px] gap-[30px]" style="order: ' . $order . ';">' . $sectionHead . $contentFunction() . '</section>';
        return $content;
    }
}

function get_section($title, $url, $order, $contentFunction): string
{
    $section = new Section();
    return $section->getSection($title, $url, $order, $contentFunction);
}
