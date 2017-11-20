<?php

namespace VS\PageBuilder\Core;

/**
 * @param string $style
 * @param string $size
 * @param array $classes
 * @return string
 */
function button_class($style = 'default', $size = 'md', array $classes = [])
{
    return "btn btn-$style btn-$size " . ( implode(' ', $classes) );
}

/**
 * @param $button
 * @return array
 */
function extract_button_info_from_content($button)
{
    return [
        'link'          => $button[ 'link' ],
        'text'          => $button[ 'text' ],
        'button_style'  => $button[ 'button_style' ],
        'button_size'   => $button[ 'button_size' ],
    ];
}